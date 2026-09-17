class Pagination {
  constructor(objName, listWrapper, paginationWrapper) {
  	this.objName = objName;
    this.listWrapper = listWrapper;
    this.paginationWrapper = paginationWrapper; 

    var totalRes = $(listWrapper).children().length;

    if (typeof $(listWrapper).data('pagination-start_page') !== 'undefined') {
    	var startPage = $(listWrapper).data('pagination-start_page');
    } else {
    	var startPage = 1;
    }

    if (typeof $(listWrapper).data('pagination-page_limit') !== 'undefined') {
    	var pageLimit = $(listWrapper).data("pagination-page_limit");
    } else {
    	var pageLimit = 12;
    }
     
    if (typeof $(listWrapper).data('pagination-margin2edges') !== 'undefined') {
		  var margin2edges = $(listWrapper).data("pagination-margin2edges");
    } else {
		  var margin2edges = 2;
    }

    if (typeof $(listWrapper).data('pagination-margin2current') !== 'undefined') {
		  var margin2current = $(listWrapper).data("pagination-margin2current");
    } else {
		  var margin2current = 1;
    }

    var lastPage = 1;
    if (totalRes > 0 && pageLimit > 0) {
    	lastPage = Math.ceil(totalRes / pageLimit);
    } else {
      $(this.paginationWrapper).hide();
    	return false;
    }

    if(startPage == 1 & lastPage == 1) {
      $(this.paginationWrapper).hide();
      return false;
    }

    this.listWrapperData = {
    	"page_limit": pageLimit,
    	"total_results": totalRes,
    	"current_page": startPage,
    	"last_page": lastPage,
    	"margin2edges": margin2edges,
    	"margin2current": margin2current
    };

    var currPage = 1;
    var i = 0;
    $(listWrapper).children().each(function() {
	    $(this).data("pagination-page", currPage);
	    $(this).attr('data-pagination-page', currPage);
		i++;
		if (i == pageLimit) {
			i = 0;
			currPage++;
		}
	});

	this.showPageItems(startPage);
  }

  showData() {
  	console.log(this.listWrapperData);
  }

  hideItems() {
  	$(this.listWrapper).children().each(function() {
	    $(this).hide();
	});
  }

  showPageItems(page) {
  	this.listWrapperData.current_page = page;
  	this.generatePagination(page);
  	this.hideItems();
  	$(this.listWrapper).children("[data-pagination-page='"+page+"']").each(function() {
      $(this).show();
    });

    document.getElementById($(this.listWrapper).attr('id')).scrollIntoView();
  }


  generatePagination(page) {
  	var str = '';
	this.objName

	if(page > 1) {
		str += ' <span onclick="(function(){'+this.objName+'.showPageItems('+(page - 1)+');})()" class="view_more_btn"><i class="fa fa-angle-left" aria-hidden="true"></i></span>';
	}
  	
  	var prevNoShow = false;
  	for (var i = 1; i <= this.listWrapperData.last_page; i++) {
  		if((i < 1 + this.listWrapperData.margin2edges) || (i > this.listWrapperData.last_page - this.listWrapperData.margin2edges) || (Math.abs(page - i) <= this.listWrapperData.margin2current)) {
  			prevNoShow = false;

  			if(i == page) {
  				str += ' <span class="view_more_btn current">'+i+'</span>';
  			} else {
  				str += ' <span onclick="(function(){'+this.objName+'.showPageItems('+i+');})()" class="view_more_btn">'+i+'</span>';
  			}
  		} else {
  			if(!prevNoShow) {
  				str += ' <span class="ellipsis">...</span>';
  				prevNoShow = true;
  			}
  		}
  	}

  	if(page < this.listWrapperData.last_page) {
		str += ' <span onclick="(function(){'+this.objName+'.showPageItems('+(page + 1)+');})()" class="view_more_btn"><i class="fa fa-angle-right" aria-hidden="true"></i></span>';
	}

	$(this.paginationWrapper).html(str);
  }
}