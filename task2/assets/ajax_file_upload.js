jQuery(function($) {
    var $iframe = $("#index-hack_frame");

    $("#index-form").submit(function() {
        this.target = $iframe.attr("name");
        $iframe.get(0).processContent = true;
    });
});

jQuery(function($) {
    $("#index-hack_frame").load(function() {
        if (!this.processContent)
            return;

        $("#index-files").get(0).value = "";

        var iframeDocument = this.contentWindow || this.contentDocument;
        iframeDocument = iframeDocument.document ? iframeDocument.document : iframeDocument;
        var data_div = $(iframeDocument.body).find("#upload_data").get(0),
            upload_data = JSON.parse(data_div.dataset.result),
            error_host = $("#index-errors").get(0),
            img_host = $("#index-imgs").get(0);

        upload_data.errors.forEach(function(error) {
            error_host.innerHTML +=
                '<div class="alert alert-danger">' + error + '</div>'
        });

        upload_data.uploaded_files.forEach(function(img) {
            img_host.innerHTML +=
                '<a target="_blank" href="' + img + '"> <img src="' + img + '" height="100"/> </a>';
        });
    });
});
