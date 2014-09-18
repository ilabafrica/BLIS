<%
/**
* Copyright (c) 2009 Infosoft Global Private Limited
*
*/
/**
*  ChangeLog / Version History:
*  ----------------------------
*
*   1.0 [ 19 February 2009 ] 
*       - Added encoders
*       - can save as JPG/PNG/GIF
*  ----- General Comments ----
*  This jsp uses the exportBean present in the request scope to get the values required for image generation.
*  Encoder is chosen based on the requested image format (JPG, PNG, GIF).
*  The StringBuffer err_warn_Codes contains the error codes if any, during the execution.
*  In case of "save" action, if the file already exists in the specified, if overwrite is off, 
*  and Intelligent File Naming is on,
*  A new unique filename is created and data is saved to that file.
*  Finally, if there are any errors, the request is forwarded to the error page.
*/
%><%@page import="java.util.HashMap" %><%@page import="java.io.OutputStream" %><%@ page import="javax.imageio.ImageIO"%><%@ page import="java.awt.image.BufferedImage"%><%@ page import="javax.imageio.stream.FileImageOutputStream"%><%@page import="java.util.Iterator" %><%@page import="java.io.File" %><%@ page import="com.fusioncharts.exporter.generators.ImageGenerator"%><%@ page import="com.fusioncharts.exporter.encoders.JPEGEncoder"%><%@ page import="com.fusioncharts.exporter.encoders.BasicEncoder"%><%@ page import="com.fusioncharts.exporter.beans.ChartMetadata"%><%@page import="com.fusioncharts.exporter.FusionChartsExportHelper"%><%@ page import="com.fusioncharts.exporter.ErrorHandler"%><jsp:useBean id="exportBean" scope="request" class="com.fusioncharts.exporter.beans.ExportBean"/><%
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

BufferedImage chartImage = ImageGenerator.getChartImage(stream,metadata);
String noticeMessage = "";
String meta_values= exportBean.getMetadataAsQueryString(null,false,isHTML);

if(!action.equals("download")){
	noticeMessage = "&notice=";
     // For servlet api before 2.1 use the following
	//String requestURL = HttpUtils.getRequestURL(request).toString();
	// in servlet api 2.1 use the following
	//String requestURL = request.getRequestURL().toString();
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
	// In Save mode, send back Successful response back to chart
	// In save mode, isHTML is false
	String pathToDisplay=FusionChartsExportHelper.HTTP_URI+"/"+fileName;
	if (FusionChartsExportHelper.HTTP_URI.endsWith("/")) {
		pathToDisplay=FusionChartsExportHelper.HTTP_URI+fileName;
	}
				
	 meta_values =exportBean.getMetadataAsQueryString(pathToDisplay,false,isHTML);
	
	// Now encode and save to file
	FileImageOutputStream fios = new FileImageOutputStream(new File(completeFilePath));
	if( exportFormat.toLowerCase().equalsIgnoreCase("jpg") || exportFormat.toLowerCase().equalsIgnoreCase("jpeg")){
		JPEGEncoder jpegEncoder = new JPEGEncoder();
		try {
			jpegEncoder.encode(chartImage,fios);
		}catch(Throwable e){
			//TODO Unable to encode the buffered image
			err_warn_Codes.append("E516,");
		}
		chartImage=null;
	}
	else {
		
		BasicEncoder basicEncoder = new BasicEncoder();
		try {
			basicEncoder.encode(chartImage,fios,1F,exportFormat.toLowerCase());
		}catch(Throwable e){
			System.out.println(" Unable to encode the buffered image");
			err_warn_Codes.append("E516,");
		}
		chartImage=null;
	}
		if(err_warn_Codes.indexOf("E")<0){
			// if there are no errors
			out.print(meta_values+noticeMessage+"&statusCode=1&statusMessage=successful");
		}

	}
	else{
			response.setContentType(FusionChartsExportHelper.getMimeTypeFor(exportFormat.toLowerCase()));
			
			OutputStream os = response.getOutputStream();
			
			if(exportTargetWindow.equalsIgnoreCase("_self")){
				response.addHeader("Content-Disposition", "attachment; filename=\""+fileName+"\"");
				//response.addHeader("Content-length",""+ios.length());
			}
			else {
				response.addHeader("Content-Disposition", "inline; filename=\""+fileName+"\"");
			}
			if( exportFormat.toLowerCase().equalsIgnoreCase("jpg") || exportFormat.toLowerCase().equalsIgnoreCase("jpeg")){
				JPEGEncoder jpegEncoder = new JPEGEncoder();
				try {
					jpegEncoder.encode(chartImage,os);
					os.flush();
				}catch(Throwable e){
					//Unable to encode the buffered image
					System.out.println("Unable to (JPEG) encode the buffered image");
					err_warn_Codes.append("E516,");
					//os.flush();
					// Note forward will not work in this case, as the output stream has already been opened
					// Hence we have to output the error directly.
					meta_values =exportBean.getMetadataAsQueryString(null,true,isHTML);
					// Reset the response to set new content type and use out instead of outputstream
					response.reset();
					response.setContentType("text/html");
					out.print(meta_values+noticeMessage+ErrorHandler.buildResponse(err_warn_Codes.toString(),isHTML));
					return;
				}
				chartImage=null;
			}
			else {
				
				BasicEncoder basicEncoder = new BasicEncoder();
				try {
					basicEncoder.encode(chartImage,os,1F,exportFormat.toLowerCase());
					os.flush();
				}catch(Throwable e){
					System.out.println("Unable to encode the buffered image");
					err_warn_Codes.append("E516,");
					//os.flush();
					// Note forward will not work in this case, as the output stream has already been opened
					// Hence we have to output the error directly.
					meta_values =exportBean.getMetadataAsQueryString(null,true,isHTML);
					// Reset the response to set new content type and use out instead of outputstream
					response.reset();
					response.setContentType("text/html");
					out.print(meta_values+noticeMessage+ErrorHandler.buildResponse(err_warn_Codes.toString(),isHTML));
					return;
				}
				chartImage=null;
			}
			// Don't close the servlet output stream
			//os.close();
			
	}
if(err_warn_Codes.indexOf("E") != -1) {
	meta_values =exportBean.getMetadataAsQueryString(null,true,isHTML);
	%><jsp:forward page="../FCExporterError.jsp" >
	<jsp:param name="errorMessage" value="<%=err_warn_Codes.toString()%>" />
	<jsp:param name="otherMessages" value="<%=meta_values%>" />
	<jsp:param name="exportTargetWindow" value="<%=exportTargetWindow%>" />
	<jsp:param name="isHTML" value="<%=isHTML%>" />
	</jsp:forward><%	return;}// end of if error%>