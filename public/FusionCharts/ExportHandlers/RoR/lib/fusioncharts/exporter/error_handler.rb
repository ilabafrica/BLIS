=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end

# Contains method to help build the error message 
class Fusioncharts::Exporter::ErrorHandler
  # Sets the errors in flash object. These flash messages can later be output in error view page
  # This method should ideally be called only once in the program execution. When an error occurs and the program halts and wants to show the error
    def self.set_flash_err(fc_error,flash,is_html,meta,fileName=nil)
         error_msgs = is_html ? fc_error.error2html : fc_error.error2qs
         warning_msgs= is_html ? fc_error.warnings2html : fc_error.warnings2qs
         flash[:notice]=warning_msgs
         flash[:error]=error_msgs
         separator = (is_html ? "<br>" : "&")
         meta_new = meta
         if(!fc_error.empty?) 
           # This means error has occured, hence statusCode=0
           # Values for width and height are 0 in case of error. FileName is empty.
           width ="0"
           height="0"
           displayPath=""
           meta_new.update({"width"=>width,"height"=>height})
         else 
           # status code =1
           flash[:error]+=separator+"statusCode=1"
           # Values for width and height in case of success. FileName is path to the file on server.
          displayPath =Fusioncharts::Exporter::Properties.HTTP_URI.gsub!(/\/$/, '') + "/" +fileName
         end
            # Whether success or failure, add file URI , width and height and DomId when status success
             flash[:error]+= is_html ? meta2html(meta_new,displayPath) : meta2qs(meta_new,displayPath) 
       end
      # Builds the query string starting with & for meta values
    def self.meta2qs(meta,fileNameWithPath)
        meta_values=""
        if(!fileNameWithPath.nil?)
          meta_values+="&fileName="+fileNameWithPath
        end
        meta_values+= "&width=" +meta ["width"]
        meta_values+= "&height=" +meta ["height"]
        meta_values+= "&DOMId=" +meta ["DOMId"]
        return meta_values
      end
      def self.meta2html(meta,fileNameWithPath)
        meta_values=""
        if(!fileNameWithPath.nil?)
          meta_values="<br>fileName="+fileNameWithPath
        end
        meta_values+= "<br>width=" +meta ["width"]
        meta_values+= "<br>height=" +meta ["height"]
        meta_values+= "<br>DOMId=" +meta ["DOMId"]
        return meta_values
      end
    
end