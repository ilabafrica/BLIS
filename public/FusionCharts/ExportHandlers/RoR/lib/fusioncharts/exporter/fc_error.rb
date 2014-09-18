class Fusioncharts::Exporter::FcError 
  #TODO Change this to attr_accessor
  attr_reader :warn_codes,:err_code
  
  @@err_messages={
    "E100"=> "Insufficient Data.",
    "E101" => "Width/height not provided.",
    "E102" => "Insufficient export parameters.",
    "E400" => "Bad Request.",
    "E401"=> "Unauthorized Access.",
    "E403"=> "Access Forbidden.",
    "E404" => "Export Resource not found.",
    "E507" => "Insufficient Storage.",
    "E508" => "Server Directory does not exist.",
    "W509" => "File already exists.",
    "W510" => "Export handler's Overwrite setting is on. Trying to overwrite.",
    "E511" => "Overwrite forbidden. File cannot be overwritten.",
    "E512" => "Intelligent File Naming is Turned off",
    "W513" => " Background color not specified. Taking White (FFFFF) as default background color.",
    "E514" => " Error while creating binary data.",
    "E515" => " Problem creating the image. Please verify that RMagick is installed correctly.",
    "E516" => " Problem creating the PDF data. Please verify that Zlib is installed correctly."
    }
  
  def initialize(ierror_code="",warning_codes=Array.new)
    @err_code = ierror_code
    @warn_codes = warning_codes
  end
  
  def warning_codes
      return @warn_codes
  end
    
  def error_code
      return @err_code
  end  
    
  
  def warnings
    warning_msgs=""
    0.upto(@warn_codes.length-1) do |i|
        message = Fusioncharts::Exporter::FcError.warning_message(@warn_codes[i])
        if(message == nil or message.empty?)
         message = "Could not find warning message for "+ @warn_codes[i] 
       end
        # This is just a warning/notice
       warning_msgs+=message
     end
     return warning_msgs
  end  
   
  def add_warning(warning_code)
    @warn_codes << warning_code
  end
  
  def set_error_code(ierror_code)
   @err_code =  ierror_code
  end

  #Gets the error message for a particular code, returns nil if not found  
  def code2message()
    err_message = @@err_messages["E"+@err_code.to_s]
    return err_message
  end 
  
  def empty?
    return @err_code.nil? || @err_code.empty? || @err_code==""
  end
  
  def no_warnings?
    return @warn_codes.empty?
  end
  
  
  def error2qs
    error_str=""
     if(@err_code==nil or @err_code.empty?)
      error_str+="&statusMessage=successful&statusCode=1"
    else 
      error_str+="&statusMessage="+code2message+"&statusCode=0"
    end
    return error_str
  end
  
  def warnings2qs
    error_str = "&notice="+warnings
    return error_str
  end

  def error2html
    error_str = ""
    if(@err_code==nil or @err_code.empty?)
      error_str+="<br>statusMessage=successful<br>statusCode=1"
    else 
      error_str+="<br>statusMessage="+code2message+"<br>statusCode=0"
    end
    return error_str
  end

  def warnings2html
    error_str = "<br>notice="+warnings
    return error_str
  end

  
  def to_qs
    error_str = warnings2qs
    error_str+=error2qs
  end
  
  def to_html
    error_str = warnings2html
     error_str+=error2html
  end
  
#Gets the error message for a particular code, returns nil if not found  
  def self.code2message(err_code)
    err_message = @@err_messages[err_code.to_s]
    return err_message
  end    
  
  def self.warning_message(warning_code)
    message = code2message("W"+warning_code)
    return message
  end
  

end

