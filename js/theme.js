var themes = document.querySelectorAll(".theme-color div");

if(typeof(localStorage) !== "undefined"){
    let color = localStorage.getItem('themeColor')
    if(color){
        document.documentElement.style.setProperty('--main-color', color);
    }
}

for (let i = 0; i < themes.length; i++) {
    const theme = themes[i];

    theme.style.backgroundColor = theme.className;

    theme.onclick = (ev) =>{
        let color = ev.target.className;
        if(typeof(localStorage) !== "undefined"){
            localStorage.setItem("themeColor", color)
        }
        document.documentElement.style.setProperty('--main-color', color);
    }
    
}