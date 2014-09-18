=begin

  Copyright (c) 2009 Infosoft Global Private Limited
 
=end
module Fusioncharts::Exporter::Generator
  class PDFGenerator
    require 'zlib'
    
 #    attr :image_data
 #    attr :width
 #    attr :height
 #    attr :bgcolor
 #    attr :compress
    # Instance Methods
    # ----------------
    def initialize(image_data,width,height,bgcolor)
     # @image_data=image_data
     # @width=width
     # @height=height
     # @bgcolor=bgcolor
      @pages_data=[]
      @pageIndex=0
      if(image_data!=nil and width!=nil and height!=nil)
        set_bitmap_data(image_data, width, height, bgcolor)
      else 
        # raise error
      end
    end
    
    def set_bitmap_data(imageData_FCFormat, width, height, bgcolor="ffffff")
      @pages_data[@pageIndex]= {:width=>width,:height=>height,:bgcolor=>bgcolor,:image_data=>imageData_FCFormat}
      @pageIndex = @pageIndex+1
		end


    def get_pdf_objects(compress=true)
      @compress = compress
       pdf_bytes =""
       #Store all PDF objects in this temporary string to be written to ByteArray
       str_tmp_obj=""
       xref_list=[]
       xref_index =0
       #start xref array
		   xref_list[xref_index]="xref\n0 "
       xref_index+=xref_index
       
		   xref_list[xref_index]="0000000000 65535 f \n" #Address Refenrece to obj 0
		   xref_index+=xref_index
       
      #Build PDF objects sequentially
      #version and header
      str_tmp_obj="%PDF-1.3\n%{FC}\n"
      pdf_bytes+=str_tmp_obj
      
      #OBJECT 1 : info (optional)
      str_tmp_obj="1 0 obj<<\n/Author (FusionCharts)\n/Title (FusionCharts)\n/Creator (FusionCharts)\n>>\nendobj\n"
      xref_list[xref_index]=calculate_xpos(pdf_bytes.length) #refenrece to obj 1
      xref_index+=xref_index
      pdf_bytes+=str_tmp_obj
      
      #OBJECT 2 : Starts with Pages Catalogue
      str_tmp_obj="2 0 obj\n<< /Type /Catalog /Pages 3 0 R >>\nendobj\n"
      xref_list[xref_index]=calculate_xpos(pdf_bytes.length) #refenrece to obj 2
      xref_index+=xref_index
      pdf_bytes+=str_tmp_obj

      #OBJECT 3 : Page Tree (reference to pages of the catalogue)
      str_tmp_obj="3 0 obj\n<<  /Type /Pages /Kids ["
      0.upto(@pageIndex-1)  do|i|
        str_tmp_obj+=(((i+1)*3)+1).to_s+" 0 R\n"
      end
      str_tmp_obj+="] /Count "+@pageIndex.to_s+" >>\nendobj\n"
      
      xref_list[xref_index]=calculate_xpos(pdf_bytes.length) #refenrece to obj 3
      xref_index+=xref_index
      pdf_bytes+=str_tmp_obj
      
      0.upto(@pageIndex-1) do|itr|
        width=@pages_data[itr][:width].to_s
        height=@pages_data[itr][:height].to_s
        
        #OBJECT 4..7..10..n : Page config
        str_tmp_obj=(((itr+2)*3)-2).to_s+" 0 obj\n<<\n/Type /Page /Parent 3 0 R \n/MediaBox [ 0 0 "+width+" "+height+" ]\n/Resources <<\n/ProcSet [ /PDF ]\n/XObject <</R"+(itr+1).to_s+" "+((itr+2)*3).to_s+" 0 R>>\n>>\n/Contents [ "+(((itr+2)*3)-1).to_s+" 0 R ]\n>>\nendobj\n"
        xref_list[xref_index]=calculate_xpos(pdf_bytes.length) #refenrece to obj 4,7,10,13,16...
        xref_index+=xref_index
        pdf_bytes+=str_tmp_obj


        #OBJECT 5...8...11...n : Page resource object (xobject resource that transforms the image)
        xref_list[xref_index]=calculate_xpos(pdf_bytes.length)  #refenrece to obj 5,8,11,14,17...
        xref_index+=xref_index
        pdf_bytes+=get_xobj_resource(itr);

        #OBJECT 6...9...12...n : Binary xobject of the page (image)
        img_BA=add_image_to_pdf(itr,@compress)
        xref_list[xref_index]=calculate_xpos(pdf_bytes.length)  #refenrece to obj 6,9,12,15,18...
        xref_index+=xref_index
        pdf_bytes+=img_BA
    end
  
    #xrefs	compilation
		xref_list[0]+=(xref_list.length-1).to_s+"\n"
		
		#get trailer
		trailer=get_trailer(pdf_bytes.length ,xref_list.length-1)
		
		#write xref and trailer to PDF
		pdf_bytes+=xref_list.to_s
		pdf_bytes+=trailer
		
		#write EOF
		pdf_bytes+="%%EOF\n"
		
		return pdf_bytes
  end
  
  
  
  def get_xobj_resource(itr)
    width=@pages_data[itr][:width].to_s
    height=@pages_data[itr][:height].to_s
    str_len_w_h= ((width+height).length)    
    return (((itr+2)*3)-1).to_s+" 0 obj\n<< /Length "+(24+str_len_w_h).to_s+" >>\nstream\nq\n"+width+" 0 0 "+height+" 0 0 cm\n/R"+(itr+1).to_s+" Do\nQ\nendstream\nendobj\n"
  end
  
  def calculate_xpos(posn)
		return (posn.to_s.rjust(10,'0'))+" 00000 n \n"
	end
  
  def get_trailer(xref_position,num_xref=7)
      return "trailer\n<<\n/Size "+num_xref.to_s+"\n/Root 2 0 R\n/Info 1 0 R\n>>\nstartxref\n"+xref_position.to_s+"\n"
  end
  
  def add_image_to_pdf(id=0, compress=true)
    @compress=compress
    bitmap_data = get_bitmap_data_24

    #PDF Object number
    img_obj_no= 6 + id*3
		
		#Get chart Image binary
		bitmap_data=get_bitmap_data_24(id)
		#Compress image binary
    if(@compress)
      begin
        cl = Zlib::Deflate
      rescue Exception
          raise NameError
      end
      image_binary = Zlib::Deflate.deflate(bitmap_data,9)
      compress_str = "/Filter /FlateDecode "
    else 
      image_binary=bitmap_data
      compress_str = ""
    end
		
		#get the length of the image binary
    len = image_binary.length
    
    width=@pages_data[id][:width].to_s
    height=@pages_data[id][:height].to_s
    
		#Build PDF object containing the image binary and other formats required
      pdf_image_str = img_obj_no.to_s+" 0 obj\n<<\n/Subtype /Image /ColorSpace /DeviceRGB /BitsPerComponent 8  /HDPI 72 /VDPI 72 "+ compress_str
      pdf_image_str+= "/Width "+width+" /Height "+height+" /Length "
      pdf_image_str+= len.to_s+" >>\nstream\n"
      pdf_image_str+= image_binary+"endstream\nendobj\n"
	   return pdf_image_str
  end

  def get_bitmap_data_24(id=0)
    image_data_24 =""
    rows = @pages_data[id][:image_data].split(";") 
    rows.each do |row|
        pixels = row.split(",") 
        pixels.each do |pixel|
          pixels_rgb=""
          c,repeat = pixel.split("_")
          if c.length <= 0 
            c=@pages_data[id][:bgcolor]
          end
          # if length of the color is less than 6 then pad zeroes
          c="#{c.rjust(6,'0')}"
          
          r = c[0,2].to_i(16)
          g= c[2,2].to_i(16)
          b=c[4,2].to_i(16)
          
          #print "R="+r.to_s
          #print "G="+g.to_s
          #print "B="+b.to_s
          
          rgbArr = [r,g,b]
          rgb = rgbArr.pack("c3")
          
          (repeat.to_i).times {pixels_rgb << rgb.to_s}

          image_data_24 << pixels_rgb 
        end # end of pixels.each
      end# end of rows.each
      return image_data_24
    end #end of function
  end
  # RMagick version
  class ImageGenerator
    require 'RMagick'
    
      # Instance Methods
      # ----------------
      def initialize(image_data,width,height,bgcolor,format)
        @image_data=image_data
        @width=width
        @height=height
        @bgcolor=bgcolor
        @format=format
      end
      
      def get_image_blob
        image = get_image
        return image.to_blob
      end
      
      def get_image
        begin 
          cl1 = Magick
          cl2=Magick::Image.new(10,10)
          cl3=Magick::Draw.new
        rescue Exception =>e
          raise NameError
        end
        if @bgcolor.nil?
          bgcolor="white"
        else 
          bgcolor="#"+@bgcolor
        end

        img = Magick::Image.new(@width, @height) {self.background_color = bgcolor}
        img.format=@format
        rows = @image_data.split(";") 
        y=0
        draw = Magick::Draw.new
        rows.each do |row|
            ### Reset the count for each new row
            ri = 0
            pixels = row.split(",") 
            pixels.each do |pixel|
              c,r = pixel.split("_")
              if c.length > 0 
                  mycolor = "#"+"#{c.rjust(6,'0')}"
                  x=ri
                  draw.fill(mycolor)
                  draw.line(x.to_s,y.to_s,(x-1+r.to_i).to_s,y.to_s)
               end #End of if c.length>0   
                ri = ri + r.to_i 
            end  # End of inner do|pixel|
              y+=1
        end # End of outer do|row|
        draw.draw(img)
        img.format=@format
        return img
      end # End of function get_image
  end # End of class
end #end of module