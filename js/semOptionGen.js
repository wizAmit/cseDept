var mon = (new Date()).getMonth();
	if (mon>1 && mon<8)
			for ( var i=2; i<9; i=i+2)
				document.write( "<option name='sem' value='"+i+"'>" + i + "</option>");
	else
			for( var i=1; i<9; i=i+2)
				document.write( "<option name='sem' value='"+i+"'>" + i + "</option>");