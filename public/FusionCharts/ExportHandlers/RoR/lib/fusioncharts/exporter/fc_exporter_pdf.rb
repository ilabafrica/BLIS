=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
class Fusioncharts::Exporter::FcExporterPdf
  require 'fusioncharts/exporter/generator'
  
  #FusionCharts Exporter -  PDF Class
  #version 2.0 [ 05 March 2009 ] - Added error handling, restructured the code.
  #version 1.0 [ 03 March 2009] - Converted from controller to ruby class

# Function to handle the export process
  def process_export(stream,meta,format)
    fc_error=nil
    @pdf_binary=nil
  begin
    fc_exporter = Fusioncharts::Exporter::Generator::PDFGenerator.new(stream, meta["width"].to_i, meta["height"].to_i, meta["bgColor"])
    # Parameter whether to compress the data or not
    @pdf_binary=fc_exporter.get_pdf_objects(true)
    #logger.info "PDF Binary created"
  rescue Exception => e
   print "Exception occurred="+e.to_s
   fc_error= Fusioncharts::Exporter::FcError.new("516")
  end
   return @pdf_binary,fc_error!=nil ? fc_error : true

  end
  
  def write_to_file(fileName)
        f = File.open(fileName, 'wb');
        f.write @pdf_binary
        f.close
  end

end
