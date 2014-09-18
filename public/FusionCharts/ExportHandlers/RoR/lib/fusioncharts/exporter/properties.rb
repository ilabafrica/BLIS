=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
# Contains properties required by the FusionCharts Export Controllers and libraries
class Fusioncharts::Exporter::Properties
    #IMPORTANT: You need to change the location of folder where 
    #     the exported chart images/PDFs will be saved on your 
 		#	  server. Please specify the path to a folder with 
 		#	  write permissions in the constant SAVE_PATH below. 
    # This path is relative to the web application root
    @@SAVEPATH = "./images/"
    
    #Used to show as message in SWF
    #This constant HTTP_URI stores the HTTP reference to 
    #the folder where exported charts will be saved. 
    #Please enter the HTTP representation of that folder 
    #in this constant e.g., http://www.yourdomain.com/images/
    @@HTTP_URI = "http://www.yourdomain.com/images/"
    
   

=begin
---------------------------- Export  Settings -------------------------------
   OVERWRITEFILE sets whether the export handler would overwrite an existing file 
the newly created exported file. If it is set to false the export handler would
not overwrite. In this case if INTELLIGENTFILENAMING is set to true the handler
would add a suffix to the new file name. The suffix is a randomly generated UUID.
Additionally, you add a timestamp or random number as additional suffix. "TIMESTAMP" or "RANDOM"
=end
    #Values allowed are true or false
    @@OVERWRITEFILE = false
    #Values allowed are true or false
    @@INTELLIGENTFILENAMING = true
    #Values allowed are "TIMESTAMP" or "RANDOM"
    @@FILESUFFIXFORMAT = "TIMESTAMP"
  
    #Users are recommended NOT to perform any editing of the following constants
    
    # Package where the export handlers are located
    # 
    #By default the path is "/Fusioncharts/exporter"
    #WARNING: If this is modified then the corresponding classes also need to change
	#DO NOT MODIFY THIS!
    @@RESOURCEPATH = "Fusioncharts/exporter"
    
    #This constant lists all the currently supported export formats
    # and related export handler file suffix.
    #e.g. for JPEG the suffix is 
    #DO NOT MODIFY THIS!
    @@HANDLERASSOCIATIONSHASH = {"PDF"=>"PDF","JPEG"=>"IMG","JPG"=>"IMG","PNG"=>"IMG","GIF"=>"IMG"}
    
    # This constant defines the name of the export handler script file
    #The name is appended with a suffix (from constant HANDLERASSOCIATIONS)
    #DO NOT MODIFY THIS!
    @@EXPORTHANDLER = "/fc_exporter_"
    
    # Methods to access these variables from other classes
    
    def self.RESOURCEPATH
      return @@RESOURCEPATH 
    end
    def self.HANDLERASSOCIATIONSHASH
      return @@HANDLERASSOCIATIONSHASH 
    end
    def self.EXPORTHANDLER
      return @@EXPORTHANDLER 
    end
    def self.SAVEPATH
      return @@SAVEPATH 
    end
    def self.HTTP_URI
      return @@HTTP_URI 
    end
    def self.FILESUFFIXFORMAT
      return @@FILESUFFIXFORMAT 
    end
    def self.OVERWRITEFILE
      return @@OVERWRITEFILE 
    end
    def self.INTELLIGENTFILENAMING
      return @@INTELLIGENTFILENAMING 
    end
    def self.SAVEPATH
      return @@SAVEPATH 
    end
    
end
