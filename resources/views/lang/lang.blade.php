<script>
    /**
     * 多语言
     */
    var langJosn=@json(lang('*'));

    var appLang={
        trans:function(str){
            //console.log(langJosn[str],str);
            if(langJosn.length<=0){
                return str+' ';
            }
            if(langJosn[str]){
                return langJosn[str]+' ';
            }
            return  str+' ';
        }
    }

</script>