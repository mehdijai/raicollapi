const authHeader = {
    Authorization:
        "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YWZkZDYyMy01NzMwLTRjYmUtYWM0Yy1jYmIzNzE4YzRmZWQiLCJqdGkiOiJjMjFhM2QxMTEyOTcwNjdhZGMzN2IxYTQ0OTk0NGM4OTQwYzJlY2ZiZjAzMmYwM2ZlOTU2Y2M3YjdhYzJjMzRjNjdlYzYzZjY3MTQwM2UwOSIsImlhdCI6MTcwNDE1MTI4NC42NDE3NTEsIm5iZiI6MTcwNDE1MTI4NC42NDE3NTMsImV4cCI6MTczNTc3MzY4NC42Mjc0NTgsInN1YiI6IjQiLCJzY29wZXMiOltdfQ.a73wic7XNToC1k0s1nwHlkmbLHf5jH71DA-BCt_M7wv1tZxerd_-VKPxYx11w9Ns_M4rdmgHCKIqxpO4NxwoiWrjZxpotwbwrGUJ7w00KZyz-dF5K5TR8QaPCnfH_CRmQ2rScE3S-zzRxT4KjddOduNam2GjgLLGQ0lKCs7f5DsJSfy_fuL_r0NSz3ErUY7aZdxKtgh29N3Cp5W2ghRGtVMQtNf5hacH8yGcvUmtMXXLIZ3AdSYxV3wjp4OVt7nJzafCSCM7HwxjLiQHLiBZyVAyRcGGHGEvMsIulicu3cjVAPssd8lBb0oQGU4IHlOhaLgtSJpA9rLG7gc2ZZCDu81ciAgKQmZEt5ELSKmzzJ1sCJXooFhn00JGqYBscXzDe5qpZi_z9yAPEL95bsb-4OoXAdToZRuEmHMPPG0wbMS1znM6QZyXJSMFJAvDg0QQBYd5AIHUad6eU1X1far9sUAi-K11MYCi9SkveeFYiVtwfBhP3hVucfD-JbxjNVZp8KtsgYiBKWUC1XVmqF--67mQMGJGCLjbV550BqP6R9rlm_h-v-_Xzqx79dOlZcW80j0zg5eOs7KmIneHF8odar3I_YLFHzjc8S2sHKqgcgfWPZ205EGDwcpzAozy3xuTw8iofno1ANJOOIkuktO1cWYNlTJd1D-sG5CW93VO4lo",
};

const audioApiUrl = "http://localhost:8000/api/audio/";

async function listTracks() {
    const list = document.getElementById("list");
    const response = await fetch(audioApiUrl + "list", {
        headers: { ...authHeader },
    });
    const result = await response.json();
    result.forEach((item) => {
        const listItem = document.createElement("li");
        listItem.innerText = item.name;
        listItem.addEventListener("click", () => {
            selectAudio(item.id);
        });
        list.appendChild(listItem);
    });
}

listTracks();

const audio = new Audio();

async function selectAudio(id) {
    const response = await fetch(audioApiUrl + "stream", {
        headers: {
            ...authHeader,
            "X-TRACK-ID": id,
        },
    });
    if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
    }
    const blob = await response.blob();
    audio.src = URL.createObjectURL(blob);
    audio.play();
    document.getElementById("playButton").disabled = true;
    document.getElementById("pauseButton").disabled = false;
}

document.getElementById("playPauseButton").addEventListener("click", () => {
    audio.pause();
    document.getElementById("playButton").disabled = false;
    document.getElementById("pauseButton").disabled = true;
});
