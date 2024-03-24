var ajax=new XMLHttpRequest();
var url="testq.php";

ajax.open("GET",url,true);
ajax.send();

ajax.onreadystatechange=function(){
    if(this.readyState==4&&this.status==200){
        var data=JSON.parse(this.responseText);
        console.log(data);
        // alert(this.responseText);
        
        var html="";
        for(var i=0;i<data.length;i++){
            var address=data[i].Response_Address;

            html+="<tr>";
                html+="<td>"+address+"</td>"
            html+="</tr>";
        }
        document.getElementById("data").innerHTML=html;
    }
}