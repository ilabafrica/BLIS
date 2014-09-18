class Fusioncharts::Exporter::FcExporter 

  @@default_parameter_values = {"exportfilename"=>"FusionCharts", "exportaction"=>"download", "exporttargetwindow"=>"_self", "exportformat"=>"PDF"}
  @@mime_list = {"jpg"=>"image/jpeg", "jpeg"=>"image/jpeg", "png"=>"image/png", "pdf"=>"application/pdf"}
  @@ext_list = {"jpg"=>"jpg", "jpeg"=>"jpg", "png"=>"png","pdf"=>"pdf"}
  
  # Can access these attributes  
  attr_reader :parsed_params
  attr_reader :exportfilename,:exportaction,:exportformat,:exporttargetwindow
  attr_reader :meta
  # Note: Not providing an accessor for stream, as this will be huge data, instead defining a method
  
  def initialize(params)
    @params = params
    @parsed_params = parse_export_request_stream
    @exportfilename = @parsed_params['parameters']['exportfilename']
    @exportaction = @parsed_params['parameters']['exportaction']
    @exportformat = @parsed_params['parameters']['exportformat']
    @exporttargetwindow = @parsed_params['parameters']['exporttargetwindow']
    #@parsed_params['parameters']['exportcallback']='FC_Exported'
    @meta = @parsed_params['meta']
  end
  # All exceptions need to be handled in the caller
  def validate
    result=true
    validation_result=validate_parameters
    if(validation_result.kind_of?(Fusioncharts::Exporter::FcError) && !validation_result.empty?)
      return validation_result
    end
    #export_action = @parsed_params['parameters']['exportaction']
 
    if(!@exportaction.eql?("download"))
      validation_result=validate_for_save(@exportfilename,@exportformat.downcase)
      if(validation_result.kind_of?(Fusioncharts::Exporter::FcError) && !validation_result.empty?)
        return validation_result
      end
    end
    return result
  end
  
  # Check if width, height and stream parameters are in order
  def validate_parameters
      validation_result = true
      validation_error =  Fusioncharts::Exporter::FcError.new
      if(@params[:meta_bgColor].nil?)
        validation_error.add_warning("513")
        validation_result =false
      end
      if(@params[:stream].nil?)
         validation_result =false
         validation_error.set_error_code("100")
      elsif(@params[:meta_width].nil? or  @params[:meta_height].nil? or @params[:meta_width].eql?("0") or @params[:meta_height].eql?("0"))
         validation_result =false
         validation_error.set_error_code("101")
      end
      return validation_result ? validation_result : validation_error
    end
    
  # Check if server is ready for save action
  def validate_for_save(filename,extension)
      #TODO Check if SAVEPATH ends with / otherwise append /
      abs_path = File.expand_path(Fusioncharts::Exporter::Properties.SAVEPATH)
      server_save_status= Fusioncharts::Exporter::SaveHelper.check_server_save_status(abs_path,filename+"."+extension,Fusioncharts::Exporter::Properties.OVERWRITEFILE,Fusioncharts::Exporter::Properties.INTELLIGENTFILENAMING)
     return server_save_status
  end
  def parse_export_request_stream
      #String of compressed data
      #Get all export parameters
      #get width and height of the chart
      #Background color of chart
      meta_hash = {"width"=>@params[:meta_width],
      "height"=>@params[:meta_height],
      "bgColor"=>@params[:meta_bgColor],
      "DOMId"=>@params[:meta_DOMId]}
      
      export_data = {"stream"=>@params[:stream],
      "parameters"=>parse_params(@params[:parameters]),
      "meta"=>meta_hash}

      return export_data
    end
    
    def parse_params(str_params)
      params_values = bang str_params
      @@default_parameter_values.update(params_values) 
      return @@default_parameter_values
    end
    
    def bang(parameters_str)
      delimiter_list = ["|","="]
      ret_hash = Hash.new([].freeze)

      parameters_str.split(delimiter_list[0]).each do |pairs|
        key, value = pairs.split('=',2).collect{|v| CGI::unescape(v) }
        if value!=nil && !value.empty?
          ret_hash[key.downcase] = value
        end
      end
     return ret_hash
  end

     
  def format_handler(str_format)
      fc_error=nil
      exporter_klass=nil
      if(Fusioncharts::Exporter::Properties.HANDLERASSOCIATIONSHASH[str_format] != nil)
        exporter_suffix = Fusioncharts::Exporter::Properties.HANDLERASSOCIATIONSHASH[str_format]
      else
        exporter_suffix = str_format
      end
      class_name_str = ((Fusioncharts::Exporter::Properties.RESOURCEPATH+Fusioncharts::Exporter::Properties.EXPORTHANDLER+ (exporter_suffix.downcase)).camelize)
      # Check if Corresponding Resource Handler Class is present
     if(class_exists?(class_name_str))
       class_name= class_name_str.constantize
       exporter_klass=class_name.new
     else 
         #error_codes="E404,"
         fc_error=Fusioncharts::Exporter::FcError.new("404")
     end
      return exporter_klass==nil ? fc_error : exporter_klass
      #Object.const_get(Fusioncharts::Exporter::Properties.BASEPACKAGE).const_get(Fusioncharts::Exporter::Properties.EXPORTERPACKAGE).const_get((Fusioncharts::Exporter::Properties.EXPORTHANDLER + exporter_suffix.downcase).camelize).new
  end
    
# Before calling this method, validate should have been called. This method does not validate for save again  
  def determine_path_to_save
    filename = @exportfilename
    format = @exportformat
    ext=format.downcase
     notice ="&notice="
      #logger.info "Saving to file on server"
      # Save File on server
      folder_to_save = File.expand_path(Fusioncharts::Exporter::Properties.SAVEPATH)
      #build filepath
      complete_file_path = File.join(folder_to_save,filename +"." + ext)
      #folder_to_save + '/' + filename +"." + ext
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
      #logger.info "Saving to location "+complete_file_path
      http_path = Fusioncharts::Exporter::Properties.HTTP_URI.gsub!(/\/$/, '')
      if(http_path==nil)
        http_path = Fusioncharts::Exporter::Properties.HTTP_URI
      end
       displayPath=  File.join(http_path,displayFileName)
       return complete_file_path,displayPath,notice
  end
     
  def mime_type(ext)
    m_type =ext
    if(@@mime_list[ext] != nil)
        m_type = @@mime_list[ext]
    end  
   return m_type 
  end
  
  def extension(format)
    ext = format.downcase
    if(@@ext_list[ext] != nil)
            ext = @@ext_list[ext]
    end  
    return ext
  end
  def stream
    return @parsed_params["stream"]
  end
  
private
   
  def class_exists?(class_name_str)
    begin
      true if class_name_str.constantize
    rescue NameError
      false
    end
  end

end
