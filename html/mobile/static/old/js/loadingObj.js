var mask_bg="<div class='dialog-bg' id='mask_bg' style='display:none;'></div>";
var mask_dialog="<div class='dialog-cont mfsj' id='mask_dialog' style='width:240px;height:80px;display:none;margin-left:50%; left: -120px;top:350px'>"+
"<div class='dialog'><div class='dialog-title2' style='text-align:center;'>操作提示</div>"+
"<div class='dialog-wram2' style='padding-left:8px;'><div class='loading-bg' style='position: absolute;top: 72px; z-index: 100000;display: inline-block;width: 45px;height: 43px;float:left;'></div><div style='position: absolute;left: 60px'>正在努力加载中……</div></div></div></div>"

function openLoading(){
	if($("#mask_bg").length==0){
		$(".wrap").append(mask_bg);
		$(".wrap").append(mask_dialog);
	}
	$("#mask_bg").show();
	$("#mask_dialog").show();
}

function closeLoading(){
	$("#mask_bg").hide();
	$("#mask_dialog").hide();
}