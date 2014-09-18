<%
/**
* Copyright (c) 2009 Infosoft Global Private Limited
*/
/**
*  ChangeLog / Version History:
*  ----------------------------
*
*   1.1 [ 19 February 2009 ] 
*       - Fixed the bug in PDF generation.
*       - GZip compression incorporated.
*   1.0 [ 16 February 2009 ] 
*       - PDF Generation Code.
*
*  ----- General Comments ----
*  This jsp uses the exportBean present in the request scope to get the values required for pdf generation.
*  The StringBuffer err_warn_Codes contains the error codes if any, during the execution.
*  In case of "save" action, if the file already exists in the specified, if overwrite is off, 
*  and Intelligent File Naming is on,
*  A new unique filename is created and data is saved to that file.
*  Finally, if there are any errors, the request is forwarded to the error page.
*/%><%@ page import="com.fusioncharts.exporter.generators.PDFGenerator"%><%@ page import="com.fusioncharts.exporter.beans.ChartMetadata"%><%@page import="com.fusioncharts.exporter.FusionChartsExportHelper"%><%@page import="java.io.OutputStream" %><%@page import="java.io.File" %><%@page import="java.io.FileOutputStream" %><%@page import="java.io.IOException" %><%@ page import="com.fusioncharts.exporter.ErrorHandler"%><jsp:useBean id="exportBean" scope="request" class="com.fusioncharts.exporter.beans.ExportBean"/><%
String action= (String)exportBean.getExportParameterValue("exportaction");
String exportFormat = (String)exportBean.getExportParameterValue("exportformat");
String exportTargetWindow = (String)exportBean.getExportParameterValue("exporttargetwindow");

String fileNameWithoutExt = (String)exportBean.getExportParameterValue("exportfilename");
String extension = FusionChartsExportHelper.getExtensionFor(exportFormat.toLowerCase());;
String fileName = fileNameWithoutExt+"."+ extension;

String stream = (String)exportBean.getStream();
ChartMetadata metadata= exportBean.getMetadata();

boolean isHTML = false;
if(action.equals("download"))
	isHTML=true;

StringBuffer err_warn_Codes = new StringBuffer();

PDFGenerator pdf = new PDFGenerator(stream,metadata);
byte[] pdfBytes= pdf.getPDFObjects(true);
String noticeMessage = "";
String meta_values= exportBean.getMetadataAsQueryString(null,false,isHTML);

if(!action.equalsIgnoreCase("download")){
	noticeMessage = "&notice=";
	String pathToWebAppRoot = getServletContext().getRealPath("/");
	String pathToSaveFolder = pathToWebAppRoot+File.separator+FusionChartsExportHelper.SAVEPATH;
	File saveFolder = new File(pathToSaveFolder);

	
	String completeFilePath = pathToSaveFolder + File.separator + fileName;
	String completeFilePathWithoutExt = pathToSaveFolder + File.separator + fileNameWithoutExt;
	File saveFile = new File(completeFilePath);
	if(saveFile.exists()) {
		noticeMessage+=ErrorHandler.getErrorForCode("W509");
		if(!FusionChartsExportHelper.OVERWRITEFILE){
			if(FusionChartsExportHelper.INTELLIGENTFILENAMING) {
				noticeMessage+=ErrorHandler.getErrorForCode("W514");
				completeFilePath= FusionChartsExportHelper.getUniqueFileName(completeFilePathWithoutExt,extension);
				File tempFile= new File(completeFilePath);
				fileName = tempFile.getName();
				noticeMessage+=ErrorHandler.getErrorForCode("W515")+ fileName;
				err_warn_Codes.append("W515,");
			}
		}
	}
	
	FileOutputStream fos = new FileOutputStream(completeFilePath);
	try {
		
		for(int i = 0; i < pdfBytes.length; i++)
			fos.write(pdfBytes[i]);
	    fos.flush();
		fos.close();
	}catch(IOException e){
		err_warn_Codes.append("E600,");
		
	}
	// In Save mode, send back Successful response back to chart
	
	String pathToDisplay=FusionChartsExportHelper.HTTP_URI+"/"+fileName;
	if (FusionChartsExportHelper.HTTP_URI.endsWith("/")) {
		pathToDisplay=FusionChartsExportHelper.HTTP_URI+fileName;
	}
	// In save mode, isHTML is false			
	meta_values =exportBean.getMetadataAsQueryString(pathToDisplay,false,isHTML);
	/*noticeMessage+="&fileName="+ pathToDisplay;
	noticeMessage+="&width="+ metadata.getWidth();
	noticeMessage+="&height="+ metadata.getHeight();*/
	if(err_warn_Codes.indexOf("E")== -1){
		// if there are no errors
		out.print(meta_values+noticeMessage+"&statusCode=1&statusMessage=successful");
	}
}
else {
	// PDF Streaming
	response.setContentType(FusionChartsExportHelper.getMimeTypeFor(exportFormat.toLowerCase()));

	if(exportTargetWindow.equalsIgnoreCase("_self")){
		response.addHeader("Content-Disposition", "attachment; filename=\""+fileName+"\"");
		//response.addHeader("Content-length",""+ios.length());
	}
	else {
		response.addHeader("Content-Disposition", "inline; filename=\""+fileName+"\"");
	}
	OutputStream os = response.getOutputStream();
	for(int i = 0; i < pdfBytes.length; i++)
		os.write(pdfBytes[i]);
	os.flush();
	//os.close();

}
if(err_warn_Codes.indexOf("E") != -1) {
	meta_values =exportBean.getMetadataAsQueryString(null,true,isHTML);
%><jsp:forward page="../FCExporterError.jsp" >
<jsp:param name="errorMessage" value="<%=err_warn_Codes.toString()%>" />
<jsp:param name="otherMessages" value="<%=meta_values%>" />
<jsp:param name="exportTargetWindow" value="<%=exportTargetWindow%>" />
</jsp:forward><%	}// end of if error
%>