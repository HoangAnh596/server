(function()
	{
		CKEDITOR.plugins.add( 'toc', {

			// Đăng ký các biểu tượng. Chúng phải khớp với tên lệnh.
			icons: 'toc',
			lang: ['de','en'],
			// Logic khởi tạo plugin nằm bên trong phương thức này.
			init: function( editor ) {

				// Xác định lệnh soạn thảo chèn dấu thời gian.
				editor.addCommand( 'insertToc', {
		
					allowedContent: '*[id,name,class]{margin-left}',
					// Xác định chức năng sẽ được kích hoạt khi lệnh được thực thi.
					exec: function( editor )
					{
						// Xóa các mã thông báo hiện có...
						var tocElements = editor.document.$.getElementsByName("tableOfContents");
						for (var j = tocElements.length; j > 0; j--) 
						{
							var oldid = tocElements[j-1].getAttribute("id").toString();
							editor.document.getById(oldid).remove();
						}
						// Tìm tất cả các tiêu đề
						var list = [],
						nodes = editor.editable().find('h1,h2,h3,h4,h5,h6,');

						if ( nodes.count() == 0 )
						{
							alert( editor.lang.toc.notitles );
							return;
						}
						// Biến đếm để tạo id duy nhất
						var counter = 1;
						var tocItems = "";
	
						// Lặp lại các tiêu đề
						for ( var i = 0 ; i < nodes.count() ; i++ )
						{
							var node = nodes.getItem(i),
								// Cấp độ có thể được sử dụng để thụt lề. nó chứa một số từ 0 (h1) đến 5 (h6).
								level = parseInt( node.getName().substr( 1 ) ) - 1;

							var text = new CKEDITOR.dom.text( CKEDITOR.tools.trim( node.getText() ), editor.document);

							var id="";
							// Kiểm tra xem tiêu đề có id không
							if (node.hasAttribute("id")) {
								id = node.getAttribute("id").toString();
							} else {
								// Tạo id tự động theo dạng "t1", "t2", ...
								id = "t" + counter;
								counter++;
								node.setAttribute('id', id);
							}
	
							// Tạo thuộc tính name dựa trên id
							node.setAttribute('name', id);
							// Xây dựng các mục toc dưới dạng div
							tocItems = tocItems + '<div style="margin-left:'+level*20+'px" id="' + id + '-toc" name="tableOfContents">' + '<a href="#' + id.toString() + '">' + text.getText().toString() + '</a></div>';
						}

						// Đầu ra ToC
						var tocNode = '<div class="seo-item-container">Mục lục' + tocItems + '</div>';
						editor.insertHtml(tocNode);
					}
				});

				// Tạo nút thanh công cụ thực hiện lệnh trên.
				editor.ui.addButton('toc', {
					label: 'Tạo mục lục',
					command: 'insertToc',
					// icon: this.path + 'icons/toc.png',
					toolbar: 'links'
				});
			}
		}
	)
})
();
