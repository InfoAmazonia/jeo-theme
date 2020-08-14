let video = document.querySelector('.entry-header iframe');

if(video) {
    const videoURL = video.attributes.src.value;

    const meta = document.createElement("meta");
    const name = document.createAttribute("name");
    name.value = "twitter:player";
    const content = document.createAttribute("content");
    content.value = videoURL;

    meta.setAttributeNode(name)
    meta.setAttributeNode(content);

    document.querySelector("#content").insertBefore(meta, document.querySelector("#content").childNodes[2]);
}