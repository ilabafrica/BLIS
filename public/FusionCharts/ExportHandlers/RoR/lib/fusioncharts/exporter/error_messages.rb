=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
class Fusioncharts::Exporter::ErrorMessages
    @@err_messages={"E100"=> "Insufficient Data.",
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
    "E511" => "Overwrite forbidden. File cannot be overwritten."
    }
    
  def self.get_error_message(error_code)
    err_message = @@err_messages[error_code.to_s]
    return err_message
  end    
end