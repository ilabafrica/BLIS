=begin
  Copyright (c) 2009 Infosoft Global Private Limited 
  FCExporter is a Controller that handles 
  FusionCharts (since v3.1) Server Side Export feature.
  This in conjuncture with other FusionCharts libraries would 
  process FusionCharts Export Data POSTED to it from FusionCharts 
  and convert the data to image or PDF and subsequently save to the 
  server or response back as http response to client side as download.
 
  This script might be called as the FusionCharts Exporter - main module 
 
     @author InfoSoft Global (P) Ltd.
     @description FusionCharts Exporter (Server-Side - RoR)
     @version 2.0 [ 19 February 2009 ]
   
 
   ChangeLog / Version History:
   ----------------------------
 
    3.0 [ 05 March 2009 ] Code refactored. Error handling improved.
    2.0 [ 19 February 2009 ] 
        - Integrated TIMESTAMP?RANDOM filename suffix and used HTTP_URI
    1.0 [ 16 February 2009 ] 
        - Integrated with new Export feature of FusionCharts 3.1
        - can save to server side directory
        - can provide download or open in browser window/frame other than _self
        - can report back to chart
        - can save as PDF/JPG/PNG/GIF
 
  GENERAL NOTES
  -------------

  Chart would POST export data (which consists of encoded image data stream,  
  width, height, background color and various other export parameters like 
  exportFormat, exportFileName, exportAction, exportTargetWindow) to this script. 
 
  The script would process this data and render_component appropriate resource files  which build 
  export binary (PDF/image) 
 
   The component either saves the binary as file to a server side directory or push it as
   Download or open in a new browser window/frame.
    
=end
class Fusioncharts::FcExporterController < ApplicationController
    require 'fusioncharts/exporter/error_handler'
    require 'fusioncharts/exporter/properties'
 
    def index
      
      @fc_exporter= Fusioncharts::Exporter::FcExporter.new(params)

      target=@fc_exporter.exporttargetwindow
      filename = @fc_exporter.exportfilename
      exportaction = @fc_exporter.exportaction
      is_html = exportaction.eql?("download")
      
      validation_result = @fc_exporter.validate # Should return true if validated,  or fc_error
      if(validation_result.kind_of?(Fusioncharts::Exporter::FcError) )
        print "%%%%% WArnings"+validation_result.warnings
        print "$$$$$ Errors="+validation_result.code2message
        Fusioncharts::Exporter::ErrorHandler.set_flash_err(validation_result,flash,is_html,@fc_exporter.meta)
        # Error has occurred, quit further processing
        redirect_to :action=>'error',:target=>target
        return
     end


    logger.info "Export Action="+ exportaction
      
    format = @fc_exporter.exportformat    
    handler =@fc_exporter.format_handler(format.upcase)
    
     if(handler.kind_of?(Fusioncharts::Exporter::FcError))
           Fusioncharts::Exporter::ErrorHandler.set_flash_err(handler,flash,is_html,@fc_exporter.meta)
          # Error has occurred, quit further processing
          redirect_to :action=>'error',:target=>target
         return
       end
    
    export_object,fc_error=handler.process_export(@fc_exporter.stream,@fc_exporter.meta,format)
    
     if(fc_error.kind_of?(Fusioncharts::Exporter::FcError))
        Fusioncharts::Exporter::ErrorHandler.set_flash_err(fc_error,flash,is_html,@fc_exporter.meta)
        # Error has occurred, quit further processing
        redirect_to :action=>'error',:target=>target
        return
     end
     logger.info("Processed using the Format Handler. Proceeding to download/save...")
    
    ext =@fc_exporter.extension(format)

    if(exportaction=="download")
      mime_type = @fc_exporter.mime_type(ext)
      logger.info("Setting mime type as "+mime_type)
        headers["content-type"]=mime_type
        if(target.downcase == "_self") 
          headers["Content-Disposition"]='attachment'
         else 
           headers["Content-Disposition"]='inline'
        end
        headers["filename"]=" " + filename +"."+ ext
      
        send_data(export_object, {:type => mime_type, :stream => true, :filename => " " + filename +"."+ ext})
       #render :content_type => 'application/octet-stream', :text => Proc.new {    |response, output|    
       # do something that reads data and writes it to output
       #export_object
       #}
          #~ #Testing 
        #~ f = File.open("C:/"+filename+"."+ext, 'wb');
        #~ f.write export_object
        #~ f.close
    else 
      # Save on server
       complete_file_path,displayPath, notice = @fc_exporter.determine_path_to_save
       handler.write_to_file(complete_file_path)
       logger.info "Saved to location on server: "+displayPath
       meta_values=Fusioncharts::Exporter::ErrorHandler.meta2qs(@fc_exporter.meta,displayPath)
       render :text=>"statusCode=1&statusMessage=successful"+notice+meta_values
      end
  end
    
  # This action will render the errors, shows the error.html.erb which contains flash[:notice] and flash[:error]
  # To build the error message as response, build_error_response method from Fusioncharts::Exporter::ErrorHandler is used
  def error
       target = params[:target]
       headers["Content-type"]="text/html"
       if(target.downcase == "_self") 
            headers["Content-Disposition"]='attachment'
      else 
            headers["Content-Disposition"]='inline'
      end
        
         logger.info("Rendering Error Page")
  end
        

end
