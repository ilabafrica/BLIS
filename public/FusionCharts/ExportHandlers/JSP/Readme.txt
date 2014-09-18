FusionCharts Server-side Export Handler - JSP
==============================================

For exporting the chart as image/pdf at server side using JSP, copy-paste the required files to your server:

1. FCExporter.jsp
2. FCExporterError.jsp
3. fcexporter.jar (contains all the dependency classes) or class files (classes in com.fusioncharts.exporter and sub-packages)
4. Resources/FCExporter_IMG.jsp
5. Resources/FCExporter_PDF.jsp
6. /Classes/fusioncharts_export.properties (configuration files)

Setup
-----
Please place the JSP in your web application, fcexporter.jar in WEB-INF/lib and fusioncharts_export.properties in WEB-INF/classes folder.

FusionCharts Exporter has been tested with Java 6.

The exportHandler attribute should have value "{Path}/FCExporter.jsp".

Configuration of save folder for server-side save
--------------------------------------------------
This is to be done in fusioncharts_export.properties file. Make sure that the folder path that you specify
has write permissions to it. 