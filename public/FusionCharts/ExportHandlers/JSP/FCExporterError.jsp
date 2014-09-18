<%@page import="com.fusioncharts.exporter.ErrorHandler" %><%
String exportTargetWindow = request.getParameter("exportTargetWindow");
String isHTML = request.getParameter("isHTML");
if(isHTML==null){
	isHTML = "true";
}
String otherMessages = request.getParameter("otherMessages");
//System.out.println(" exportTargetWindow ="+exportTargetWindow);
//System.out.println("other messages = "+request.getParameter("otherMessages") + "error messages = "+request.getParameter("errorMessage"));

if(otherMessages==null){
	otherMessages="";
}
String errorMessage = request.getParameter("errorMessage");
if(errorMessage==null){
	errorMessage="";
}
response.setContentType("text/html");
if(exportTargetWindow.equalsIgnoreCase("_self")){
	response.addHeader("Content-Disposition", "attachment;");
}
else {
	response.addHeader("Content-Disposition", "inline;");
}
%><%= ErrorHandler.buildResponse(request.getParameter("errorMessage"),new Boolean(isHTML).booleanValue()) %><%=otherMessages %>
<%//out.close();%>