console.log("YO");
var d_regulation=document.getElementById('reg');
var d_batch=document.getElementById('acad');
console.log(d_regulation.value)
d_regulation.addEventListener('change',mychange);
function mychange(e){
    var r=e.target.options[e.target.options.selectedIndex].value;
    console.log(e.target.options[e.target.options.selectedIndex].value);
    if(r!=''){
        if(r=='R-15'){
            d_batch.innerHTML=`
                <option value="">--SELECT--</option> 
                <option value="2015-2019">2015-2019</option> 
                <option value="2016-2020">2016-2020</option>
                <option value="2017-2021">2017-2021</option>
                `;
        }
        else if(r=='R-18'){
            d_batch.innerHTML=`<option value="">--SELECT--</option> <option value="2018-2022">2018-2022</option> 
                `;
        }
        else if(r=='R-19'){
            d_batch.innerHTML=`<option value="">--SELECT--</option> <option value="2019-2023">2019-2023</option> 
                `;
        }
        else if(r=='R-20'){
            d_batch.innerHTML=`<option value="">--SELECT--</option> <option value="2020-2024">2020-2024</option> 
                `;
        }
        else if(r=='R-21'){
            d_batch.innerHTML=`<option value="">--SELECT--</option> <option value="2021-2025">2011-2025</option> 
                `;
        }
    }
    else{
        d_batch.innerText=`<option value="">--SELECT--</option>`;
    }
}