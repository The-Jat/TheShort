$(document).ready(function(){    

    if($('[data-trigger=chart]').length > 0){
        $('[data-trigger=chart]').each(function(){
            charts($(this), $(this).data('url'));
        });

        $('input[name=customreport]').on('apply.daterangepicker', function(ev, picker) {
            
            if( window.clickchart !== undefined) window.clickchart.destroy();

            charts($('[data-trigger=chart'), $('[data-trigger=chart').data('url')+'?from='+picker.startDate.format('MM/DD/YYYY')+'&to='+picker.endDate.format('MM/DD/YYYY'));
        
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
    }   
    
    if($('[data-trigger=dynamic-map]').length > 0){

        maps($('[data-trigger=dynamic-map]'), $('[data-trigger=dynamic-map]').data('url'));		

        $('input[name=customreport]').on('apply.daterangepicker', function(ev, picker) {

            window.map.reset();
            
            maps($('[data-trigger=dynamic-map]'), $('[data-trigger=dynamic-map]').data('url')+'?from='+picker.startDate.format('MM/DD/YYYY')+'&to='+picker.endDate.format('MM/DD/YYYY'));
        
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });        
	}

    if($('[data-trigger=dynamic-pie]').length > 0){
        $('[data-trigger=dynamic-pie]').each(function(){
            piechart($(this), $(this).data('url'));
        });

        $('input[name=customreport]').on('apply.daterangepicker', function(ev, picker) {

            if( window.datachart !== undefined) window.datachart.destroy();
            
            piechart($('[data-trigger=dynamic-pie]'), $('[data-trigger=dynamic-pie]').data('url')+'?from='+picker.startDate.format('MM/DD/YYYY')+'&to='+picker.endDate.format('MM/DD/YYYY'));
        
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });    
	}
});
function cities(code){
    let el = $('[data-toggle=cities]');

    if(el.length == 0) return false;

    $.get(el.data('url')+'?country='+code, function(response){
        el.html(response);
    })
    .fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: "bottom",
                align: "right"
            },
        });
    });	
}
function piechart(el, url){

    $.get(url, function(data){
        let labels = [];			
        let counts = [];

        for(var x in data['chart']){
            labels.push(x);
            counts.push(data['chart'][x]);
        }			
        window.datachart = new Chart(el, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    borderWidth: 5,
                    backgroundColor: ['#BAE1FF', '#FFDFBA', '#FFFFBA', '#BAFFC9', '#FFB3BA', '#FFBAF1', '#FFABAB', '#FFC3A0', '#FF677D', '#D4A5A5', '#392F5A', '#B9FBC0', '#A0E7E5', '#F9FBCB', '#F6B93B']
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                plugins:{
                    legend: {
                        position: 'bottom',
                        display: true
                    }
                },
                cutoutPercentage: 75
            }
        });
        if(data['top']){
            $('#top-'+el.data('type')).html('');
            let totalCount = 0;
            for (const [key, value] of Object.entries(data['top'])) {
                totalCount += value;
            }
            
            for (const [key, value] of Object.entries(data['top'])) {
                if(el.data('type') == 'languages'){
                    let percentage = ((value / totalCount) * 100).toFixed(2);
                    $('#top-'+el.data('type')).append('<li class="position-relative d-block mb-2 w-100 border-bottom pb-2 fw-bold"><div class="bg-primary position-absolute d-block h-100 rounded" style="z-index:0;opacity:0.1;width:'+percentage+'%;min-height:30px;"></div><div class="position-relative px-1 pt-1"><span class="align-middle">'+key+'</span> <span class="float-end float-right"><span class="fw-bold">'+value+' ('+percentage+'%)</span></span></div></li>');percentage
                } else {                
                    let thumb = appurl+'static/images/'+el.data('type')+'/'+key.split(' ')[0].toLowerCase()+'.svg';
                    if(key.split(' ')[0] == 'Unknown') thumb = appurl+'static/images/unknown.svg';                
                    let percentage = ((value / totalCount) * 100).toFixed(2);
                    $('#top-'+el.data('type')).append('<li class="position-relative d-block mb-2 w-100 border-bottom pb-2 fw-bold"><div class="bg-primary position-absolute d-block h-100 rounded" style="z-index:0;opacity:0.1;width:'+percentage+'%;min-height:30px;"></div><div class="position-relative px-1 pt-1"><img src="'+thumb+'" width="16" class="mr-1 me-1"><span class="align-middle">'+key+'</span> <span class="float-end float-right"><span class="fw-bold">'+value+' ('+percentage+'%)</span></span></div></li>');
                }
            }
        }
    })
    .fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: "bottom",
                align: "right"
            },
        });
    });
}
function charts(el, url){

    $.get(url, function(data){
        let datax = [];			
        let datay = [];			
        let gradient = el.get()[0].getContext('2d').createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, el.data('color-start') ? el.data('color-start') : 'rgba(0, 138, 255, 1)');
        //gradient.addColorStop(1, el.data('color-start') ? el.data('color-stop') : 'rgba(255,255,255,0)');
         

        for(var x in data['data']){
            datax.push(x);
            datay.push(data['data'][x]);
        }
        
        if(data['count']){
            for(var id in data['count']){
                if($('[data-count='+id+']').length > 0) $('[data-count='+id+']').text(data['count'][id]);
            }
        }

        window.clickchart = new Chart(el, {
            type: 'bar',
            data: {
                labels: datax,
                datasets: [{
                    label: data['label'],
                    fill: true,
                    tension: 0.3,
                    backgroundColor: gradient,
                    borderColor:  el.data('color-border') ? el.data('color-border') : '#008aff',
                    borderWidth: 2,
                    borderRadius: 5,
                    borderSkipped: 'bottom',
                    data: datay
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {display: false},
                tooltips: {intersect: false}, hover: {intersect: true},
                plugins: {filler: {propagate: false}, legend: {display: false}},
                scales: {
                    x: { grid: {display: false}, min: 0},
                    y: { grid: {display: false}, min: 0}
                }
            }
        });		
    }).fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });
    });	
}
function maps(el, url){
    $.get(url, function(data){
        window.map = new jsVectorMap({
            map: "world",
            selector: "#"+el.attr('id'),
            zoomButtons: true,
            visualizeData: {
                scale: ['#a6d1f5', '#008aff'],
                values: data['list']
            },					
            regionsSelectable: true,
            regionsSelectableOne: true,
            zoomOnScroll: true,
            onRegionTooltipShow(tooltip, index) {
                tooltip.text(
                    tooltip.text() + ' ('+ (typeof data['list'][index] != 'undefined'  ? data['list'][index] : 0) + ')'
                )
            },
            onRegionSelected(code) {
                cities(code);
            }
        });
        $('#top-countries').html('');
        let totalCountriesCount = 0;
        for (const [key, value] of Object.entries(data['top'])) {
            totalCountriesCount += value.count;
        }
        
        for (const [key, value] of Object.entries(data['top'])) {
            let thumb = appurl+'static/images/flags/'+key.toLowerCase()+'.svg';
            if(value.name == 'Unknown') thumb = appurl+'static/images/unknown.svg';
            let percentage = ((value.count / totalCountriesCount) * 100).toFixed(2);
            $('#top-countries').append('<li class="position-relative d-block mb-2 w-100 border-bottom pb-2 fw-bold"><div class="bg-primary position-absolute d-block position-absolute h-100 rounded" style="z-index:0;opacity:0.1;width:'+percentage+'%;min-height:30px;"></div><div class="position-relative px-1 pt-1"><img src="'+thumb+'" width="16" class="mr-1 me-1"><span class="align-middle">'+value.name+'</span> <span class="float-end float-right"><span class="fw-bold">'+value.count+' ('+percentage+'%)</span></span></div></li>');
        }
        if(typeof data['cities'] !== undefined && data['cities']){
            $('#top-cities').html('');
            let totalCitiesCount = 0;
            for (const [key, value] of Object.entries(data['cities'])) {
                totalCitiesCount += value.count;
            }
            for (const [key, value] of Object.entries(data['cities'])) {
                let thumb = appurl+'static/images/flags/'+value.country.toLowerCase()+'.svg';
                if(value.name == 'Unknown') thumb = appurl+'static/images/unknown.svg';
                let percentage = ((value.count / totalCitiesCount) * 100).toFixed(2);
                $('#top-cities').append('<li class="position-relative d-block mb-2 w-100 border-bottom pb-2 fw-bold"><div class="bg-primary position-absolute d-block position-absolute h-100 rounded" style="z-index:0;opacity:0.1;width:'+percentage+'%;min-height:30px;"></div><div class="position-relative px-1 pt-1"><img src="'+thumb+'" width="16" class="mr-1 me-1"><span class="align-middle">'+value.name+'</span> <span class="float-end float-right"><span class="fw-bold">'+value.count+' ('+percentage+'%)</span></span></div></li>');
            }
        }
        window.addEventListener("resize", () => {
            window.map.updateSize();
        });
    })
    .fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: "bottom",
                align: "right"
            },
        });
    });
}