=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
class Fusioncharts::Exporter::FcExporterImg
  require 'fusioncharts/exporter/generator'

  #FusionCharts Exporter -  IMAGE Class
  #version 2.0 [ 19 February 2009]

# Function to handle the export process
  def process_export(stream,meta,format)
    fc_error = nil
    @image=nil
    #ext = format.downcase
   @image=nil
    begin
      image_generator = Fusioncharts::Exporter::Generator::ImageGenerator.new(stream, meta["width"].to_i, meta["height"].to_i, meta["bgColor"],format)
      @image=image_generator.get_image
    rescue Exception => e
      print "Exception occurred="+e.to_s
      fc_error= Fusioncharts::Exporter::FcError.new("515")
    end
   return @image!=nil ? @image.to_blob : @image,fc_error!=nil ? fc_error : true
      
  end
  
  def write_to_file(fileName)
    @image.write(fileName)
  end
end
