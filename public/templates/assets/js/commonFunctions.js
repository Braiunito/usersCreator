export var hide = "d-none";
export var danger = "alert alert-danger";
export var success = "alert alert-success";

export function hideMessage(timeout, object) {
    object.style = "opacity: 1";
    setTimeout(() => {
        fadeMsg(20, object)
    }, timeout);
}

export function fadeMsg(interval, object) {
    let opacity = 0.99;
    let fade = setInterval(() => {
        if (opacity < 0) {
            object.className = hide;
            clearInterval(fade);
        }
        opacity = opacity-0.01;
        object.style = "opacity: "+opacity;
    }, interval);
}