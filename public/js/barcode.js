/**
 * Custom javascript function for barcode generation
 * @author  (c) @iLabAfrica
 */
 function getBarcode(code)
{		    
    if(code == '')
    {
        alert('cannot be empty');
        return;
    }
    var count = parseInt($('#count').html()); 
    count = count + 1;
    $('#count').html(count);  
    var div = "bar"+count;
    generateBarcode(div, code);
}

function generateBarcode(div, code)
{
    var content = "<br><br><div id='"+div+"'></div>";
    $('#barcodeList').html(content);
        $("#"+div).barcode(code, 'code39',{barWidth:2, barHeight:30, fontSize:11, output:'css'});
}

function PrintElem(elem, code)
{
    
    Popup($(elem).html(), code);
}

function Popup(data, code) 
{
    var mywindow = window.open('', 'my div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>Barcodes</title>');
    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();
    //mywindow.document.show
    return true;
}

function get_barcode(code)
{
     if(code == '')
        {
            alert('cannot be empty');
            return;
        }
    var count = parseInt($('#count').html()); 
    count = count + 1;
    $('#count').html(count);  
    var div = "bar"+count;
    var content = "<br><br><div id='"+div+"'></div>";
    $('#barcodeList').html(content);
        $("#"+div).barcode(code, 'code39',{barWidth:2, barHeight:30, fontSize:11, output:'css'});
    var data = $('#barcodeList').html();
    var mywindow = window.open('', 'my div', 'height=400,width=600');
    mywindow.document.write('<html><head><title>Barcodes</title>');
    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.print();
    mywindow.close();    
}