=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
#Helps in saving the files on server Contains methods to check whether server is ready for save or not, generate a unique filename
class Fusioncharts::Exporter::SaveHelper
   require "digest"
   #Checks whether the server is ready for download
  def self.check_server_save_status(folder_to_save,filename,overwrite,intelligent_file_naming)
    validation_result=true
    validation_error = Fusioncharts::Exporter::FcError.new
    # check whether directory exists
    #raise error and halt execution if directory does not exists
    count=0
    if(!FileTest.exists?(folder_to_save))
      validation_error.set_error_code("508")
      return validation_error
    end
    # check if directory is writable or not
    is_dir_writable = File.writable?( folder_to_save ) 
      if(!is_dir_writable)
        validation_error.set_error_code("403")
        return validation_error
      end
    #build filepath
    complete_file_path = folder_to_save + '/' + filename 
    
    # check whether file exists
    if ( FileTest.exists?(complete_file_path )) 
      validation_error.add_warning("509")
      validation_result=false
      #if overwrite is on return with ready flag 
      if ( overwrite ) 
          # add notice while trying to overwrite
          validation_error.add_warning("510")
          validation_result=false
          # see whether the existing file is writable
          # if not halt raising error message
          if(!File.writable?( complete_file_path ) ) 
            validation_error.set_error_code("511")
            return validation_error
          end
      else 
        # File already exists, file overwrite is false , check IntelligentFileNaming
        if(!intelligent_file_naming)
          validation_error.set_error_code("512")
          return validation_error
        end
      end
    end	
      # return with ready flag / error code, if there are warnings/error return error object
      return validation_result ? validation_result  : validation_error
    end    
  # Generates Unique filename with suffix either a TIMESTAMP  or RANDOM number
  def self.generate_unique_filename(complete_file_path_without_ext,extension) 
    #print "Generating unique id..."
       md5_str=""
       finished=false
       until finished
          md5 = Digest::MD5.new
          now = Time.now
          md5 << now.to_s
          md5 << String(now.usec)
          md5 << String(rand(0))
          md5 << String($$)
          #md5 << constant
          md5.hexdigest
          if(Fusioncharts::Exporter::Properties.FILESUFFIXFORMAT=="TIMESTAMP")
            md5_str = md5.to_s + "_" + Time.now.strftime("%m%d%Y%S").to_s 
          else 
            md5_str = md5.to_s + "_" + Array.new(9){rand 10}.join 
          end
          finished=!FileTest.exists?(complete_file_path_without_ext+md5_str+"."+extension)
      end
      #print "Generated"
      return complete_file_path_without_ext+md5_str + "." + extension
    end

end