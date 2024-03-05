var count;
function addStudent(counter){
	window.console.log("jbhj");
	counter++;
	let clone_node;
	let clone_node_final;
	if(count==0){
		// count=localStorage["count"];
		let item=document.getElementById("student_fee0");
		// let item_final=document.getElementById("final0");
		clone_node=item.cloneNode(true);
		// clone_node_final=item_final.cloneNode(true);
		count++;
		clone_node.id="student_fee"+count;
		(clone_node.querySelectorAll("input")[0]).id="admno"+count;
		
		// (clone_node.querySelectorAll("select")[0]).id="st"+count;
		window.console.log("Printing");
		(clone_node.querySelectorAll("select")[0]).id="en"+count;
		
		document.getElementById("index").value=count;
		// clone_node_final.id="final"+count;
		// var a=document.getElementById("final0");
		item.parentNode.insertBefore(clone_node,item.nextSibling);
		// document.getElementById("student_fee1").parentNode.insertBefore(clone_node_final,document.getElementById("student_fee1").nextSibling);
		(document.getElementById("student_fee"+count).querySelectorAll("input")[0]).setAttribute("name","admno"+count);
		// (document.getElementById("student_fee"+count).querySelectorAll("select")[0]).setAttribute("name","st"+count);
		(document.getElementById("student_fee"+count).querySelectorAll("select")[0]).setAttribute("name","en"+count);
		window.console.log("Student Hey"+count);
		(document.getElementById("student_fee"+count).querySelectorAll("legend")[0]).innerHTML="Student"+count;
		// if(document.getElementById("final"+(count-1))!=null){
		// 	(document.getElementById("final"+count).querySelectorAll("legend")[0]).innerHTML="Fees"+count;
		// }
		localStorage["count"]=count;
		sessionStorage.setItem("count",count);
	}
	else{
		count=localStorage["count"];
		var count1=parseFloat(count);
		var count3=(parseFloat(count)+1)*2-1;
		window.console.log("final Hello"+count1);
		window.console.log("Current count value"+count1);
		let item=document.getElementById("student_fee"+count1);
		// var item_final=document.getElementById("final").querySelectorAll("fieldset")[0];
		// item_final=item_final[count];
		// let item1=item;
		clone_node=item.cloneNode(true);
		count1++;
		// clone_node_final=item_final.cloneNode(true);
		clone_node.id="student_fee"+count1;
		(clone_node.querySelectorAll("input")[0]).id="admno"+count1;
		
		// (clone_node.querySelectorAll("select")[0]).id="st"+count1;
		
		(clone_node.querySelectorAll("select")[0]).id="en"+count1;
		
				document.getElementById("index").value=count1;
				// clone_node_final.id="final"+count;
		// document.getElementById('student_fee'+count).appendChild(clone_node);
		item.parentNode.insertBefore(clone_node,item.nextSibling);
		// document.getElementById("student_fee"+count).appendChild(clone_node_final);
		(document.getElementById("student_fee"+count1).querySelectorAll("input")[0]).setAttribute("name","admno"+count1);
		// (document.getElementById("student_fee"+count1).querySelectorAll("select")[0]).setAttribute("name","st"+count1);
		(document.getElementById("student_fee"+count1).querySelectorAll("select")[0]).setAttribute("name","en"+count1);
		var count2=parseFloat(count)+1;
		window.console.log("Student"+count2);
		(document.getElementById("student_fee"+count1).querySelectorAll("legend")[0]).innerHTML="Student"+count1;
		// if(document.getElementById("final"+count)!=null){
		// 	(document.getElementById("final"+count).querySelectorAll("legend")[0]).innerHTML="Fees"+count2;
		// }
//		count=count+1;
		localStorage["count"]=count1;
		sessionStorage.setItem("count",count1);
	}
}
window.onload=function(){
	count=0;
	// count=localStorage["count"];
	localStorage['count']=count;
	window.console.log("Above");
	// document.getElementById("count").innerHTML="Hello";
	window.console.log("Below");
	let a=document.getElementById("student_fee0");
	let student=a.querySelectorAll("legend");
		(student[0]).innerHTML="Student"+count;
		if(document.getElementById("final0")!=null){
	(document.getElementById("final0").querySelectorAll("legend")[0]).innerHTML="Fees"+count;
	sessionStorage.setItem('count',count);
	document.getElementById("index").querySelectorAll("input").value=count;
	window.console.log("Below");
}


}