	


    var width = 320, 
    height = 240, 
    maxFileSize = 2 * 1024 * 1024, // (байт) Максимальный размер файла (2мб)
    selectedFiles = {},
    queue = [],
    image = new Image(),
    imgLoadHandler,
    errorMsg;

    function resizeImage(w_orig, h_orig, width, height){
    	if(width == undefined){
    		width = 320;
    	}
    	if(height == undefined){
    		height = 240;
    	}

		if(w_orig > h_orig){
			height = (h_orig*width)/w_orig;
		}else if(h_orig > w_orig){
			width = (w_orig * height)/h_orig;
		}
		newSize = [width, height];
		return newSize;
	}

    $('.preview').on('click', function() {
        var error = $('.error');
        var prevContainer = $('.modal-body');
        var name = $('#name').val();
        var email = $('#email').val();
        var text = $('#comment').val();
        var block = '<div class="col-md-12 task"><div class="row"><div class="col-md-5 image"><span class="glyphicon glyphicon-ok-circle"></span>';
        // block += '<img src = "" class="img-rounded" alt = "imageTask">';
        block += '</div><div class="col-md-7"><div class="col-md-12"><h2>' + name + '</h2></div><div class="col-md-12"><b>Email:</b> <span class = "label label-primary">' + email + '</span></div><div class="col-md-12 task_text"><p>' + text + '</p></div></div></div></div>';
        prevContainer.html(block);


// ----------------------------------------

        var newFiles = $("input[type=file][id=file]")[0].files; // массив с выбранными файлами
 
            var file = newFiles[0];
 
            // Валидация файлов (проверяем формат и размер)
            if ( errorMsg = validateFile(file) ) {
                // alert(errorMsg);
                error.html(errorMsg);
                return;
            }
        if(file){
            // Добавляем файл в объект selectedFiles
            selectedFiles[file.name] = file;
            queue.push(file);

            $(this).val('');
            processQueue(); // запускаем процесс создания миниатюры
        }
	});

	var validateFile = function(file){
        if(file != undefined){
            if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
                return 'Фотография должна быть в формате jpg, png или gif';
            }

            if ( file.size > maxFileSize ) {
                return 'Размер фотографии не должен превышать 2 Мб';
            }
        }

        return ;
    };
 
    var listen = function(element, event, fn) {
        return element.addEventListener(event, fn, false);
    };


    var processQueue = function(){

        var file = queue.pop(); 
 

        var span = document.createElement('SPAN');

        var newSize = resizeImage(image.width, image.height);
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
 		
 
        image.removeEventListener('load', imgLoadHandler, false);
        var newSize = resizeImage(image.width, image.height);
        canvas.setAttribute('width', newSize[0]);
        canvas.setAttribute('height', newSize[1]);
        // создаем миниатюру
        imgLoadHandler = function() {
        	var newSize = resizeImage(image.width, image.height);
        	// alert('width:' + newSize[0]+ ' height:' + newSize[1]);
            ctx.drawImage(image, 0, 0, newSize[0], newSize[1]);
            URL.revokeObjectURL(image.src);
            span.appendChild(canvas);
        };
 

        $(".image").html(span);
        listen(image, 'load', imgLoadHandler);
        image.src = URL.createObjectURL(file);
 

	};