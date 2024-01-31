 var th = ['', 'thousand', 'million', 'billion', 'trillion'];
        // uncomment this line for English Number System
        // var th = ['','thousand','million', 'milliard','billion'];
        
        var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
        var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        function lookup(amount)
                  {
                    if(parseFloat(amount)<=0 ) return '-';
                     var money = amount.split('.');
                    var words;
                    var naira = money[0];
                    var kobo = money[1];            
                    var word1 = toWords(naira);
                    //return word1.substr(word1.length - 4)
                    if  (word1.substr(word1.length - 4)=="and " && word1.substr(word1.length - 5)!="sand "){
                        word1=word1.substring(0,word1.length - 4)
                    }
                   word1= word1?word1 +" naira":''
                    //word1 = word1 +" naira";
                    var word2 = word1? ", "+toWords(kobo)+" kobo": toWords(kobo)+" kobo";
                    if(kobo != "00" && kobo)
                      words = word1 + word2;
                    else
                      words = word1;
                    //document.getElementById('result').innerHTML =words.toUpperCase(); 
                    words=words + " only";
                    return words.toUpperCase(); 
                  }
        function toWords(s) {

                s = s.toString();
                s = s.replace(/[\, ]/g, '');
                if (s != parseFloat(s)) return '';
                var x = s.indexOf('.');
                if (x == -1) x = s.length;
                if (x > 15) return 'too big';
                var n = s.split('');
                var str = '';
                var sk = 0;
                for (var i = 0; i < x; i++) {
                    if ((x - i) % 3 == 2) {
                        if (n[i] == '1') {
                            str += tn[Number(n[i + 1])] + ' ';
                            i++;
                            sk = 1;
                        } else if (n[i] != 0) {
                            str += tw[n[i] - 2] + ' ';
                            sk = 1;
                        }
                    } else if (n[i] != 0) {
                        str += dg[n[i]] + ' ';
                        if ((x - i) % 3 == 0) str += 'hundred and ';
                        sk = 1;
                    }
                    if ((x - i) % 3 == 1) {
                        if (sk) str += th[(x - i - 1) / 3] + ' ';
                        sk = 0;
                    }
                }
                if (x != s.length) {
                    var y = s.length;
                    str += 'point ';
                    for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
                }
                return str.replace(/\s+/g, ' ');
            }