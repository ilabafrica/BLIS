=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
class Fusioncharts::FcExporterPdfController < ApplicationController
  require 'fusioncharts/exporter/generator'
  #FusionCharts Exporter -  PDF Class
  #version 2.0 [ 19 February 2009]

# Function to handle export process
  def export_processor
    export_data = params[:export_data]
    stream = export_data[:stream]
    meta = export_data[:meta]
    format = export_data[:parameters][:exportformat]
    filename = export_data[:parameters][:exportfilename]
    action = export_data[:parameters][:exportaction]
    target = export_data[:parameters][:exporttargetwindow]
    ext=format.downcase
    
    fc_exporter = Fusioncharts::Exporter::Generator::PDFGenerator.new stream, meta["width"].to_i, meta["height"].to_i, meta["bgColor"]
    # Parameter whether to compress the data or not
    pdf_binary=fc_exporter.get_pdf_objects(true)
    logger.info "PDF Binary created"

      if(action=="download")
        headers["content-type"]="application/pdf"
        if(target.downcase == "_self") 
          headers["Content-Disposition"]='attachment'
         else 
           headers["Content-Disposition"]='inline'
        end
        headers["filename"]=" " + filename +"."+ ext
        
        send_data(pdf_binary, {:type => "application/pdf", :stream => true, :filename => " " + filename +"."+ ext})
      else 
        # Save file on server
        logger.info "Saving to file on server"
        notice="&notice="
        # Save File on server
        folder_to_save = File.expand_path(Fusioncharts::Exporter::Properties.SAVEPATH)
        #build filepath
        complete_file_path = folder_to_save + '/' + filename +"." + ext
        displayFileName = filename +"." + ext
        #Check if file exists and create new filename
        if(FileTest.exists?(complete_file_path))
          notice += " File already exists."
          if( !Fusioncharts::Exporter::Properties.OVERWRITEFILE)
            notice += " Using intelligent naming of file by adding an unique suffix to the exising name."
            # create new filename
            complete_file_path= Fusioncharts::Exporter::SaveHelper.generate_unique_filename(folder_to_save + '/' + filename ,ext)
            displayFileName=File.basename(complete_file_path)
            notice += " The filename has changed to "+displayFileName
           end
        end
        
        logger.info "Saving to location "+complete_file_path
        
        f = File.open(complete_file_path, 'wb');
        f.write pdf_binary
        f.close
        
        displayPath=  Fusioncharts::Exporter::Properties.HTTP_URI.gsub!(/\/$/, '') + "/" +displayFileName
        logger.info "Saved to location on server "+displayPath
        # Save => is_html is false use &
      meta_values=Fusioncharts::Exporter::SaveHelper.build_meta_query_string(meta,displayPath)
      render :text=>"statusCode=1&statusMessage=successful"+notice+meta_values
      end
  end
end
