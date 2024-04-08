var BaseJs = {
	createIt: function(options){
		var GLOBAL_JS = options.globalJs;

		var base = {
			_alert:function(msg){
				alert(msg);
			},
      _upload: function(el){
        var inputs = document.querySelectorAll(el);
        console.log(inputs);
        Array.prototype.forEach.call( inputs, function( input )
    		{
    			var label	 = input.nextElementSibling,
    				labelVal = label.innerHTML;

    			input.addEventListener( 'change', function( e )
    			{
    				var fileName = '';
    				if( this.files && this.files.length > 1 )
    					fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
    				else
    					fileName = e.target.value.split( '\\' ).pop();

    				if( fileName )
    					label.querySelector( 'span' ).innerHTML = fileName;
    				else
    					label.innerHTML = labelVal;
    			});

    			// Firefox bug fix
    			input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
    			input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
    		});

        document.getElementById('file-1').addEventListener("change", function(){
          $('#properties').fadeIn();
        });

      },
      _tableList: function(){
        $('#tbl-compression').dataTable({
            "bProcessing": true,
            "sAjaxSource": options.siteURL + 'imagecompressor/getData',
            "bPaginate":true,
            "sPaginationType":"full_numbers",
            "iDisplayLength": 10,
            "aoColumns": [
              { mData: 'ID' } ,
							{ mData: 'Thumb' } ,
              { mData: 'OriginalImage' },
              { mData: 'Created' },
              { mData: 'Compression' },
              { mData: 'Action' }
            ]
        });
      },
			init: function(){
				this._upload('.inputfile');
        this._tableList();
      }
		};

		return base;
	}
}
