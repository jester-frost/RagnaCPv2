jQuery(function(){
    // Valores Iniciais
    // points = "a=197","b=325" "c=99","d=268" "e=99","f=155" "g=197","h=98" "i=295","j=155" "k=295","l=268"
    var a,b,c,d,e,f,g,h,i,j,k,l = 0; 
    a = 310; // 310
    b = 530; // Int Baixo 650
    c = 175; // 80
    d = 460; // 520
    e = 175; // 80
    f = 304; // 250
    g = 306;
    h = 229; // STR topo
    i = 436; // 530
    j = 304; // 250
    k = 436;
    l = 455;

        stat_str = 5;
        stat_agi = 5;
        stat_vit = 5;
        stat_inte = 5;
        stat_dex = 5;
        stat_luk = 5;

    $(document).ready(function() {

        function verifica(){
            jQuery('#stat_str input').val(stat_str);
            jQuery('#stat_agi input').val(stat_agi);
            jQuery('#stat_dex input').val(stat_dex);
            jQuery('#stat_vit input').val(stat_vit);
            jQuery('#stat_inte input').val(stat_inte);
            jQuery('#stat_luk input').val(stat_luk);
            console.log( stat_str, stat_agi, stat_vit, stat_inte, stat_dex, stat_luk);
        }

        $("#char-select-list a").click(function() {
            $("#char-select-list a").removeClass("active");
            $(this).toggleClass("active");
        });

        $(".button.btnstr").click(function() {
            if (stat_str < 9){
                stat_str++;
                stat_inte--;
                $("#poligon").attr("points", a+","+(b=b-30)+" "+c+","+d+" "+e+","+f+" "+g+","+(h=h-30)+" "+i+","+j+" "+k+","+l); 
            }
            else{
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+e+","+f+" "+g+","+h+" "+i+","+j+" "+k+","+l); 
            }
            verifica();
            return false;
        });

        $(".button.btnvit").click(function() {
            if (stat_vit < 9){
                stat_vit++;
                stat_dex--;
                $("#poligon").attr("points", a+","+b+" "+(c=c+23.75)+","+(d=d-15)+" "+e+","+f+" "+g+","+h+" "+(i=i+23.5)+","+(j=j-13.5)+" "+k+","+l);
            }
            else{
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+e+","+f+" "+g+","+h+" "+i+","+j+" "+k+","+l); 
            }
            verifica();
            return false;
        });

        $(".button.btnluk").click(function() {
            
            if (stat_luk < 9){
                stat_luk++;
                stat_agi--;
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+(e=e+23.75)+","+(f=f+13.5)+" "+g+","+h+" "+i+","+j+" "+(k=k+24)+","+(l=l+15));                
            }
            else{
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+e+","+f+" "+g+","+h+" "+i+","+j+" "+k+","+l); 
            }
            verifica();
            return false;
        });

        $(".button.btnint").click(function() {       
            if (stat_inte < 9){
                stat_inte++;
                stat_str--;
                $("#poligon").attr("points", a+","+(b=b+30)+" "+c+","+d+" "+e+","+f+" "+g+","+(h=h+30)+" "+i+","+j+" "+k+","+l);                
            }
            else{
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+e+","+f+" "+g+","+h+" "+i+","+j+" "+k+","+l); 
            }
            verifica();
            return false;
        });

        $(".button.btndex").click(function() {
            if (stat_dex < 9){
                stat_dex++;
                stat_vit--;
                $("#poligon").attr("points", a+","+b+" "+(c=c-23.75)+","+(d=d+15)+" "+e+","+f+" "+g+","+h+" "+(i=i-23.5)+","+(j=j+13.5)+" "+k+","+l);                
            }
            else{
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+e+","+f+" "+g+","+h+" "+i+","+j+" "+k+","+l); 
            }
            verifica();
            return false;
        });

        $(".button.btnagi").click(function() {
            
            if (stat_agi < 9){
                stat_agi++;
                stat_luk--;
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+(e=e-23.75)+","+(f=f-13.5)+" "+g+","+h+" "+i+","+j+" "+(k=k-24)+","+(l=l-15));                
            }
            else{
                $("#poligon").attr("points", a+","+b+" "+c+","+d+" "+e+","+f+" "+g+","+h+" "+i+","+j+" "+k+","+l); 
            }
            verifica();
            return false;
        });
    });


    // Cabelos

    jQuery('.char-arrows .arrow').click(function(){
        return false;
    })


    jQuery('.char-arrows .arrow-top').click(function(){
        var cor = jQuery('.cor');

        if(cor.find('> li.active').next().length){
            cor.find('> li.active').removeClass('active').next().addClass('active');

        }else{
            cor.find('> li').removeClass('active').first().addClass('active');
        }

        jQuery('.hair_color').val( cor.find('> li.active').index() );

    })

    jQuery('.char-arrows .arrow-right').click(function(){
        if(jQuery('.cor > li > .estilo').find('> li.current').next().length){
            jQuery('.cor > li > .estilo').find('> li.current').removeClass('current').next().addClass('current');
        }else{
            jQuery('.cor > li > .estilo').find('> li').removeClass('current').parent().find('li:first-child').addClass('current');
        }
        jQuery('.hair').val( jQuery('.cor > li.active > .estilo ').find(' > li.current').index() );
    })

    jQuery('.char-arrows .arrow-left').click(function(){
        if(jQuery('.cor > li > .estilo').find('> li.current').prev().length){
           jQuery('.cor > li > .estilo').find('> li.current').removeClass('current').prev().addClass('current');
        }else{
            jQuery('.cor > li > .estilo').find('> li').removeClass('current').parent().find('li:last-child').addClass('current');
        }
        jQuery('.hair').val( jQuery('.cor > li.active > .estilo ').find(' > li.current').index() );
    })

});