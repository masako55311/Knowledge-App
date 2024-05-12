
// ブックマーク切り替え
function addBookmark(idx){
  var i=idx;
  var a=document.getElementById(`bkmkicon-${i}`);
  var chk=document.getElementById(`check-${i}`);
  
  if(chk.checked){
    a.innerHTML="bookmark";
  }else{
    a.innerHTML="bookmark_border";
  }
}

// 検索窓open
function openSearch(){
  document.getElementById("search_form").style.display = "block";
  //document.getElementById("search_form").style.height = "200px";
}
// 検索窓close
function closeSearch(){
  document.getElementById("search_form").style.display = "none";
}

// ページTopに戻る
window.addEventListener('load', function(){
  const scroll_to_top_btn = document.querySelector('#scroll-to-top-btn');
  scroll_to_top_btn.addEventListener( 'click' , scroll_to_top_ev );

function scroll_to_top_ev(){
  window.scroll({top: 0 , behavior: 'smooth'});
};
});



