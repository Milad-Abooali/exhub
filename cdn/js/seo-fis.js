$(document).ready(function() {

    /**
     * SEO FIS
     */

    // Progress Circle  - seo/fis
    $('.p-circle').each(function() {
        let ratio = $(this).data('ratio');
        $(this).circleProgress({
            value: ratio,
            size: 95,
            fill: {color: 'rgb('+((ratio>0.37)?0:255)+','+(ratio*200)+',0)'}
        }).on('circle-animation-progress', function(event, progress, stepValue) {
            $(this).find('strong').text(stepValue.toFixed(2));
        });
    });
    // Ajax Add Fis - seo/fis
    $('body').on('click','.doA-fisopen', function(){
        let thisClick = $(this);
        let rid = thisClick.data('rid');
        let eid = thisClick.data('eid');
        data = "keyword_id="+rid+"&engin="+eid;
        ajaxCall ('seo/addFis', data,function(response) {
            let obj = JSON.parse(response);
            let type = (obj.e) ? 'danger' : 'success';
            let text = (obj.e) ? 'Error, status not change '+obj.res : 'Success, User status updated.';
            if (obj.res) {
                // thisClick.removeAttr('href');
                thisClick.removeClass('doA-fisopen').addClass('cb-ob-1');
                let ratio = $('#circle-'+rid).data('ratio')+0.09;
                $('#circle-'+rid).data('ratio',ratio);
                $('#ratio-'+rid).text(ratio);
                $('#circle-'+rid).circleProgress({value: ratio});
                $('#circle-'+rid).circleProgress({fill: {color: 'rgb('+((ratio>0.37)?0:255)+','+(ratio*200)+',0)'}});
            }
        });
    });

});

