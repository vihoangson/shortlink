class Emoji {
    constructor(backgroundAnimate) {
        this.id = 0;
        this.step = 0;
        this.position = 0;
        this.m = null;
        this.backgroundAnimate = backgroundAnimate;
        this.selector = null;
    }
    runAnimations() {
        this.m = setInterval(() => {
            this.step = this.step - 1;
            this.position = this.step * 130;
            let css = {
                "background-position": this.position + "px",
                width: "130px",
                height: "130px",
                "background-image": "url(" + this.backgroundAnimate + ")"
            };
            this.selector.css(css);
        }, 100);
        setTimeout(() => {
            clearInterval(this.m);
            this.m = null;
        }, 5000);
        this.selector.hover(() => {
            if (this.m === null) {
                this.runAnimations();
            }
        });

    }

    addEvent() {
        this.selector.click(() => {
            console.log(this.id);
            eventBus.trigger('addEmoji', {id: this.id});
        })
    }

}

const listEmoji = [
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41317&size=130&checksum=fea0a6f586a345f11dad32742eced7cc",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45839&size=130&checksum=c99cc7fa3139336ffae6ca6c8b8c9cfd",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45825&size=130&checksum=6c1c4d648be6159386220d3d6a11aa13",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45826&size=130&checksum=c92ca88ec8b5ceca8dd33511fd36b526",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45827&size=130&checksum=8ac1531e000c36f29bddaee04d95decb",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45828&size=130&checksum=094995202354a8b760c959806f060cf8",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45832&size=130&checksum=1951897cd068740162ae2b209c890193",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45831&size=130&checksum=4871c49d050937aebe03d49b3e890936",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45830&size=130&checksum=ea8e95fd0c5befb5c441378c453ff5dd",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45829&size=130&checksum=66c36312c704cbe6c37fddb059dac831",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45833&size=130&checksum=befdefa40f2689da12a6519e00e9014c",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45834&size=130&checksum=cab2be212373b35e67d9c47c9b2e415b",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45835&size=130&checksum=20a5d33cade76b206cb6ca5b80f10574",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45836&size=130&checksum=3e2faf94c014a4abeb53f8b6811be690",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45840&size=130&checksum=68b39274a48a7dda6940a5a9e11528be",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45839&size=130&checksum=c99cc7fa3139336ffae6ca6c8b8c9cfd",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45838&size=130&checksum=a067bfe814a8606278be207327615d52",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=45837&size=130&checksum=2545eba909edcbce00e18a8a6cf9b451",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41308&size=130&checksum=a8499e77109a4408c9363d83b970a0aa",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41309&size=130&checksum=c33024579f6716922b17430a5a5bb269",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41310&size=130&checksum=203ab3f1303c179e84363b60c971542c",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41311&size=130&checksum=3fbb22ca179f3e0b246575af5acf1184",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41315&size=130&checksum=3d98d1dc59f0fb782338d2cb91b342de",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41314&size=130&checksum=dd50d0cc0ec0f5988b841ccb7fdf108d",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41313&size=130&checksum=73e69bfa2bb7fa7b27713bf042d75075",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41312&size=130&checksum=375be3ef839f13c1c98652d4dd282f49",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41316&size=130&checksum=3415116f08675f5ddd7093b730d325ef",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41317&size=130&checksum=fea0a6f586a345f11dad32742eced7cc",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41318&size=130&checksum=9b750486770042d8e65da5ae16d2450f",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41319&size=130&checksum=f2eef84eeee2201d515b73fedc57840d",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41323&size=130&checksum=1111fed8ee11477ad6dce14ea5e743ba",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41322&size=130&checksum=792bf575f4ac621043595159eb5978cf",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41321&size=130&checksum=9d71ad6113ecd9c4a8cf475c7e32c99d",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41320&size=130&checksum=c964e27d325b7da39e3596559e4a13a5",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41324&size=130&checksum=1e8e43f8fa89aaa5558ea5b64d8aad74",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41325&size=130&checksum=d39c9d00ef0762e791923da533358641",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41326&size=130&checksum=9c3f8fea3070d53866991d3c214d700f",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41327&size=130&checksum=5e4fc6bee5919b3cbada5b9f17b3f10d",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41331&size=130&checksum=44f5e9bc6f826eada35206d0d4fa0cd9",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41330&size=130&checksum=f4ebbb3f77f90e91b8b09f3ddedf646b",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41329&size=130&checksum=3d17ab465e937b61f519f607b55e5d90",
    "https://zalo-api.zadn.vn/api/emoticon/sprite?eid=41328&size=130&checksum=926b0cefbb42bd81efd0ac9601ad0cf9",
]
var mmm = [];
listEmoji.forEach((v, k) => {
    mmm[k] = new Emoji(v);
    $("#emoji").prepend($("<div class='div"+k+"'>"));
    mmm[k].id = k;
    mmm[k].selector = $(".div" + k);
    mmm[k].runAnimations();
    mmm[k].addEvent();
})

