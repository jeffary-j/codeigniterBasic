$(function () {

    /*
     * 갤러리
     */
    $('#gallery').each(function () {

        var $container = $(this),
            $loadMoreButton = $('#load-more'), // 추가 버튼
            $filter = $('#gallery-filter'),    // 필터링 양식
            addItemCount = 15,                 // 한 번에 표시 할 항목 수
            addedd = 0,                        // 표시 된 항목 수
            allData = [],                      // 모든 JSON 데이터
            filteredData = [];                // 필터링 된 JSON データ


        // JSON을 검색하고 initGallery 함수를 실행
        //$.getJSON("/FrontgateEm/emData", initGallery());
        //$.getJSON("/assets/emJs/content.json", initGallery);
        $.ajax({
	        dataType: 'json',
	        url: '/post/getPostList?per_page='+per_page,
	        success:function(data){
		        $container.masonry({
		            columnWidth: 310,
		            gutter: 10,
		            itemSelector: '.gallery-item'
		        });
		        
		        if(data.code != "00") return false;

		        var gallery = data.gallery;
		        if(gallery.total < 1) return false;
		        
		        per_page += gallery.row.length;

		        // 취득한 JSON 데이터를 저장
	            allData['gallery'] = gallery.row;
	
	            filteredData = allData['gallery'];

	            // 첫 번째 항목을 표시
	            addItems();
	
	            // 추가 버튼을 클릭하면 추가로 표시
	            $loadMoreButton.on('click', function(){
		            per_page ++; 
		            addItems();
	            });
	
	            // 필터 라디오 버튼이 변경되면 필터링을 수행
	            $filter.on('change', 'input[type="radio"]', filterItems);
	
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	            // 항목 링크에 호버 효과 처리 등록
	            $container.on('mouseenter mouseleave', '.gallery-item a', hoverDirection);
	// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	        }
        });

        
        // 항목을 생성하고 문서에 삽입
        function addItems(filter) {
            var elements = []
            // 추가 데이터의 배열
            var slicedData = filteredData.slice(addedd, addedd + addItemCount);
				
            // slicedData의 요소마다 DOM 요소를 생성
            $.each(slicedData, function (i, item) {
	            
	            // over text ellipsis
	            var titleStr = function(string){
		            if(string.length > 25){
			            return string.substring(0, 25) + '...';
		            } else {
			            return string;
		            }
	            }
	            var itemRegdate = item.regdate;
	            
                var itemHTML =
                        '<li class="gallery-item is-loading">' +
                            '<a href="/post/info/' + item.idx + '">' +
                                '<img src="/attach_file/post/' + item.user_idx + '/' + item.idx + '/'+ item.photo_t + '" alt="" />' +
                                '<span class="caption">' +
                                    '<span class="inner">' +
                                        '<b class="title">' + titleStr(item.contents) + '</b>' +
                                    '</span>' +
                                '</span>' +
                            '</a>' +
                        '</li>';
                elements.push($(itemHTML).get(0));
            });

            // DOM 요소의 배열을 컨테이너에 넣고 Masonry 레이아웃을 실행
            $container
                .append(elements)
                .imagesLoaded(function () {
                    $(elements).removeClass('is-loading');
                    $container.masonry('appended', elements);

                    // 필터링시 재배치
                    if (filter) {
                        $container.masonry();
                    }
                });

            // 링크에 Colorbox 설정
/*
            $container.find('a').colorbox({
                maxWidth: '970px',
                maxHeight: '95%',
                title: function () {
                    return $(this).find('.inner').html();
                }
            });
*/

            // 추가 된 항목 수량 갱신
            addedd += slicedData.length;

            // JSON 데이터가 추가 된 후에 있으면 추가 버튼을 지운다
            if (addedd < filteredData.length) {
                $loadMoreButton.show();
            } else {
                $loadMoreButton.hide();
            }
        }

        // 필터링
        function filterItems () {
            var key = $(this).val(); 
            // 추가 된 Masonry 아이템
            var masonryItems = $container.masonry('getItemElements');

            // Masonry 항목을 삭제
            $container.masonry('remove', masonryItems);

            // 필터링 된 항목의 데이터를 재설정과
            // 추가 된 항목 수를 재설정
            filteredData = [];
            addedd = 0;

            if (key == '0') {
                // all이 클릭 된 경우 모든 JSON 데이터를 저장
                filteredData = allData['gallery'];
            } else {
                // all 이외의 경우, 키와 일치하는 데이터를 추출

                filteredData = $.grep(allData['gallery'], function (item) {
	                var items = item.categorys;
// 	                console.log(items["0"].category_sort);
	                var itemSort = items["0"].category_sort;
                    return itemSort == key;
                });
                
                
            }
            // 항목을 추가
            addItems(true);
        }

// 06-04에 추가
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // 호버 효과
        function hoverDirection (event) {
            var $overlay = $(this).find('.caption'),
                side = getMouseDirection(event),
                animateTo,
                positionIn = {
                    top:  '0%',
                    left: '0%'
                },
                positionOut = (function () {
                    switch (side) {
                        // case 0: top, case 1: right, case 2: bottom, default: left
                        case 0:  return { top: '-100%', left:    '0%' }; break; // top
                        case 1:  return { top:    '0%', left:  '100%' }; break; // right
                        case 2:  return { top:  '100%', left:    '0%' }; break; // bottom
                        default: return { top:    '0%', left: '-100%' }; break; // left
                    }
                })();
            if (event.type === 'mouseenter') {
                animateTo = positionIn;
                $overlay.css(positionOut);
            } else {
                animateTo = positionOut;
            }
            $overlay.stop(true).animate(animateTo, 250, 'easeOutExpo');
        }

        // 마우스의 방향을 감지하는 함수
        // http://stackoverflow.com/a/3647634
        function getMouseDirection (event) {
            var $el = $(event.currentTarget),
                offset = $el.offset(),
                w = $el.outerWidth(),
                h = $el.outerHeight(),
                x = (event.pageX - offset.left - w / 2) * ((w > h)? h / w: 1),
                y = (event.pageY - offset.top - h / 2) * ((h > w)? w / h: 1),
                direction = Math.round((Math.atan2(y, x) * (180 / Math.PI) + 180) / 90  + 3) % 4;
            return direction;
        }
    });
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

    // jQuery UI Button
    $('.filter-form input[type="radio"]').button({
        icons: {
            primary: 'icon-radio'
        }
    });
    
    

    

});
