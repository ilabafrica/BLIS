For exporting the chart as image or pdf on server side using Ruby on Rails, the following files are required.

          FILES REQUIRED
-----------------------------------

Controllers
-----------
/Fusioncharts/
1. fc_exporter_controller.rb
2. fc_exporter_img_controller.rb
3. fc_exporter_pdf_controller.rb

lib
---
fusioncharts/exporter/

4. error_handler.rb
5. error_messages.rb
6. generator.rb
7. properties.rb
8. save_helper.rb

views
-----
9. error.html.erb

For Save As JPG / PNG/ GIF, RMagick is the pre-requisite. Please install RMagick and all its dependencies.

For saving as PDF, 'zlib' is the pre-requisite.

          SET-UP
-----------------------------------------
1. Copy the controllers (1,2,3) into controllers/Fusioncharts in your application.
2. Copy the lib folder along with lib files (4,5,6,7,8) into lib folder of your application.
3. Copy the fc_exporter folder along with error.html.erb into the views folder of your application.

Now in the xml for the chart, specify the exporthandler value to be "Fusioncharts/fc_exporter/index"

Sample Builder XML with export attributes is shown below:

xml = Builder::XmlMarkup.new
xml.chart(:caption=>'Monthly Unit Sales', :xAxisName=>'Month', :yAxisName=>'Units', :showValues=>'0', :formatNumberScale=>'0', :showBorder=>'1',:exportEnabled=>'1', :exportHandler=>'/Fusioncharts/fc_exporter/index', :exportFormats=>'JPG|PDF',:exportaction=>'download',:exporttargetwindow=>'_self') do
  xml.set(:label=>'Jan',:value=>'462') 
  xml.set(:label=>'Feb',:value=>'857') 
  xml.set(:label=>'Mar',:value=>'671')
  xml.set(:label=>'Apr',:value=>'494')
  xml.set(:label=>'May',:value=>'761')
  xml.set(:label=>'Jun',:value=>'960')
  xml.set(:label=>'Jul',:value=>'629') 
  xml.set(:label=>'Aug',:value=>'622')
  xml.set(:label=>'Sep',:value=>'376')
  xml.set(:label=>'Oct',:value=>'494')
  xml.set(:label=>'Nov',:value=>'761')
  xml.set(:label=>'Dec',:value=>'960')
end

That's it.
