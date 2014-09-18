<%/**
*
* FusionCharts Exporter is a jsp that handles
* FusionCharts (since v3.1) Server Side Export feature.
* This in conjuncture with other resource jsps and classes would 
* process FusionCharts Export Data POSTED to it from FusionCharts 
* and convert the data to image or PDF and subsequently save to the 
* server or response back as http response to client side as download.
*
* This jsp might be called as the FusionCharts Exporter - main module 
*
*    @author InfoSoft Global (P) Ltd.
*    @description FusionCharts Exporter (Server-Side - JSP)
*    @version 1.0 [ 18 February 2009 ]
*  
*/
/**
*  ChangeLog / Version History:
*  ----------------------------
*
*   1.0 [ 18 February 2009 ] 
*       - Integrated with new Export feature of FusionCharts 3.1
*       - can save to server side directory
*       - can provide download or open in browser window/frame other than _self
*       - can report back to chart
*       - can save as PDF/JPG/PNG/GIF
*
*/
/**
* Copyright (c) 2009 Infosoft Global Private Limited
*
*/
/**
*  GENERAL NOTES
*  -------------
*
*  Chart would POST export data (which consists of encoded image data stream,  
*  width, height, background color and various other export parameters like 
*  exportFormat, exportFileName, exportAction, exportTargetWindow) to this script. 
*  
*  The script would process this data using appropriate resource files build 
*  export binary (PDF/image) 
*
*  It either saves the binary as file to a server side directory or push it as
*  Download or open in a new browser window/frame.
*
*
*  ISSUES
*  ------
*   Q> What if someone wishes to open in the same page where the chart existed as postback
*      replacing the old page?
* 
*   A> Not directly supported using any chart attribute or parameter but can do by
*      removing/commenting the line containing request.setHeader("content-disposition ...'
*     
*/ 

/**
 *   @requires	FCExporter_{format}.jsp  as export resouce for the specific format 
 *      e.g. FCExporter_PDF.jsp (containing PDF Releated Export resource functionality)
 *      FCExporter_IMG.jsp (containing JPEG/PNG/GIF Releated Export resource functionality)
 *
 *   Details
 *   -------
 *   Based on the format, the request would be forwarded to appropriate resource jsp
 *
 *   FusionChartsExportHelper contains the following, which will be used by these resources.
 * @see com.fusioncharts.exporter.FusionChartsExportHelper
 *
 *   	a) a HashMap - MIMETYPES contains key as a format name specified in the 
 *		   handlerAssociationsMap. The associated value
 *		   would be the mimetype for the specified format.
 *		   
 *		   e.g. "jpg=image/jpeg,jpeg=image/jpeg,png=image/png,gif=image/gif"
 *
 *
 *		b) a HashMap - EXTENSIONS that contains key value pair. Each key would again be the 
 *		   format name and the extension would be the file extension.
 *		   
 *		   e.g. "jpg=jpg,jpeg=jpg,png=png,gif=gif" 
 *
 *
 *      c) a HashMap -handlerAssociationsMap Contains key as format name and value as associated Handler suffix.
 *
 *         e.g. "JPG=IMG,PDF=PDF, GIF=IMG"
 *
 *		d) FusionChartsExportHelper also contains constants whose values can be modified from fusioncharts_export.properties file
 *         which should be present in the classpath if you want to modify the default values.
 *
 */

%>
<%@page import="java.util.HashMap" %>
<%@page import="java.util.Iterator" %>
<%@page import="java.io.File" %>
<%@page import="java.util.StringTokenizer" %>

<%@page import="com.fusioncharts.exporter.FusionChartsExportHelper" %>
<%@page import="com.fusioncharts.exporter.beans.ExportBean" %>
<%@page import="com.fusioncharts.exporter.ErrorHandler" %>

<%
	/*
FCExporter.jsp has logic to validate the parameters, putting default values for missing parameters and 
then forwarding the request to appropriate jsp based on the requested export format.
*/
StringBuffer err_warn_Codes = new StringBuffer();
String WEB_ROOT_PATH = application.getRealPath("/");
String pathSeparator = File.separator; // will return either "\" or "/", depends on OS
String validation_def_filepath = WEB_ROOT_PATH+pathSeparator+FusionChartsExportHelper.RESOURCEPATH+"validation_def.jsp";
String relativePathToValidationDef = FusionChartsExportHelper.RESOURCEPATH+"validation_def.jsp";


/* ToDo - Not complete */
File f = new File(validation_def_filepath);
if(f.exists()) {
		// include this file
%>
<jsp:include page="<%=relativePathToValidationDef%>"/>
<%}


ExportBean localExportBean=FusionChartsExportHelper.parseExportRequestStream(request);

String exportFormat = (String)localExportBean.getExportParameterValue("exportformat");
String exporterFilePath = FusionChartsExportHelper.getExporterFilePath(exportFormat);
String exportTargetWindow = (String)localExportBean.getExportParameterValue("exporttargetwindow");

if (localExportBean.getMetadata().getWidth() == -1 || localExportBean.getMetadata().getHeight() == -1 || 
		localExportBean.getMetadata().getWidth() == 0 || localExportBean.getMetadata().getHeight() == 0 ) {
	
	//If Width/Height parameter is not sent, the ChartMetadata will have width/height as -1
	//Raise Error E101 - Width/Height not found
	err_warn_Codes.append("E101,");	
}

if (localExportBean.getMetadata().getBgColor() == null) {
	
	//Background color not available
	err_warn_Codes.append("W513,");	
}

if (localExportBean.getStream() == null  ) {
	
	//If image data not available
	//Raise Error E100
	err_warn_Codes.append("E100,");	
}

String exportAction = (String)localExportBean.getExportParameterValue("exportaction");
boolean isHTML = false;
if(exportAction.equals("download"))
	isHTML=true;

if(!exportAction.equals("download")) {
	String fileNameWithoutExt = (String)localExportBean.getExportParameterValue("exportfilename");
	String extension = FusionChartsExportHelper.getExtensionFor(exportFormat.toLowerCase());;
	String fileName = fileNameWithoutExt+"."+ extension;	
	err_warn_Codes.append(ErrorHandler.checkServerSaveStatus(WEB_ROOT_PATH,fileName));
	
}


if(err_warn_Codes.indexOf("E") != -1) {
String meta_values= localExportBean.getMetadataAsQueryString(null,true,isHTML);
%>
<jsp:forward page="FCExporterError.jsp" >
<jsp:param name="errorMessage" value="<%=err_warn_Codes.toString()%>" />
<jsp:param name="otherMessages" value="<%=meta_values%>" />
<jsp:param name="exportTargetWindow" value="<%=exportTargetWindow%>" />
<jsp:param name="isHTML" value="<%=isHTML%>" />
</jsp:forward>
<%
	return;
}
//Now include the jsp for this file format
//Check if this file exists before including
%>

<jsp:useBean id="exportBean" scope="request" class="com.fusioncharts.exporter.beans.ExportBean">
	<jsp:setProperty name="exportBean" property="metadata" value="<%=localExportBean.getMetadata()%>"/> 
	<jsp:setProperty name="exportBean" property="stream" value="<%=localExportBean.getStream()%>"/>
	<jsp:setProperty name="exportBean" property="exportParameters" value="<%=localExportBean.getExportParameters()%>"/>
</jsp:useBean>
<% File exporter = new File(WEB_ROOT_PATH+pathSeparator+exporterFilePath);

if(exporter.exists()){%>
<jsp:forward page="<%=exporterFilePath%>" />
<% }else {/* exception*/}%>