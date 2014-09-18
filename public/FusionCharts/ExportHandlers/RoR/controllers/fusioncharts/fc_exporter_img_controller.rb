=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
class Fusioncharts::FcExporterImgController < ApplicationController
  require 'fusioncharts/exporter/generator'
  require 'fusioncharts/exporter/save_helper'
  require 'fusioncharts/exporter/properties'
  #FusionCharts Exporter -  IMAGE Class
  #version 2.0 [ 19 February 2009]

# Function to handle the export process
  def export_processor
    export_data = params[:export_data]
    stream = export_data["stream"]
    meta = export_data["meta"]
    format = export_data["parameters"]["exportformat"]
    filename = export_data["parameters"]["exportfilename"]
    action = export_data["parameters"]["exportaction"]
    target = export_data["parameters"]["exporttargetwindow"]
    ext = format.downcase
    
    fc_exporter = Fusioncharts::Exporter::Generator::ImageGenerator.new stream, meta["width"].to_i, meta["height"].to_i, meta["bgColor"],format
    image=fc_exporter.get_image
  
    
    mime_list = {"jpg"=>"image/jpeg", "jpeg"=>"image/jpeg", "png"=>"image/png"}
    ext_list = {"jpg"=>"jpg", "jpeg"=>"jpg", "png"=>"png"}
    if(ext_list[ext] != nil)
          ext = ext_list[ext]
    end

    if(action=="download")
        headers["content-type"]=mime_list[ext]
        if(target.downcase == "_self") 
          headers["Content-Disposition"]='attachment'
         else 
           headers["Content-Disposition"]='inline'
        end
        headers["filename"]=" " + filename +"."+ ext
        image_blob=image.to_blob
        send_data(image_blob, {:type => mime_list[ext], :stream => true, :filename => " " + filename +"."+ ext})
    else 
      notice ="&notice="
      logger.info "Saving to file on server"
      # Save File on server
      folder_to_save = File.expand_path(Fusioncharts::Exporter::Properties.SAVEPATH)
      #build filepath
      complete_file_path = folder_to_save + '/' + filename +"." + ext
      displayFileName = filename +"." + ext
      #Check if file exists and create new filename
      if(FileTest.exists?(complete_file_path))
          notice += " File already exists."
          if( !Fusioncharts::Exporter::Properties.OVERWRITEFILE)
            notice+= " Using intelligent naming of file by adding an unique suffix to the exising name."
            # create new filename
            complete_file_path= Fusioncharts::Exporter::SaveHelper.generate_unique_filename(folder_to_save + '/' + filename ,ext)
            displayFileName=File.basename(complete_file_path)
            notice+= "The filename has changed to "+displayFileName
          end
      end
      logger.info "Saving to location "+complete_file_path
       
      image.write(complete_file_path)
      image=nil
      displayPath=  Fusioncharts::Exporter::Properties.HTTP_URI.gsub!(/\/$/, '') + "/" +displayFileName
       logger.info "Saved to location on server: "+displayPath
      meta_values=Fusioncharts::Exporter::SaveHelper.build_meta_query_string(meta,displayPath)
      render :text=>"statusCode=1&statusMessage=successful"+notice+meta_values
    end
  end

end
