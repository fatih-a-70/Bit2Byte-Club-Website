const navLinks=document.querySelectorAll(".nav-link");
navLinks.forEach(link=>{
  if(link.getAttribute("href")===window.location.pathname.split("/").pop()){
    link.classList.add("active");
  }else{
    link.classList.remove("active");
  }
});