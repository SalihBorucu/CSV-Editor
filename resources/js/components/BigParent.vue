<template>
    <div>

        <div :class="{cont: true, inactive:isInActive, active: isActive, elActive:isActive }" >
            <transition name="pop">
            <div v-if="notReady" class="alert alert-danger" role="alert">
                Got to complete the previous step, buddy!
            </div>
        </transition>
            <div class="cont__inner">
                <div :class="{el: true, sketchyThick: true, active:1 == selected}"  >
                    <div class="el__overflow">
                        <div class="el__inner">
                            <div class="el__bg"></div>
                            <div class="el__preview-cont" @click="selected = 1, isActive=true" >
                                <h2>CHOOSE YOUR CSV FILE</h2>
                            </div>
                            <div class="el__content" >
                                <csvupload @navigate="navigate" @load="csvFileText" :isActive="isActive" :selected="selected"></csvupload>
                                <div class="el__close-btn" @click="isActive = false, selected=undefined"  ></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="{el: true, sketchyThick: true, active:2 == selected}"  >
                    <div class="el__overflow">
                        <div class="el__inner">
                            <div class="el__bg"></div>
<!--                            <div class="el__preview-cont" @click="selected = 2, isActive=true">-->
                            <div class="el__preview-cont" @click="valiStep1">
                                <h2>SELECT COLUMNS TO FILTER</h2>
                            </div>
                            <div class="el__content">
                                <filterdata @navigate2="navigate2" :allTitles="allTitles" :dataCol="dataCol" @filtered-data="filteredData" :dataRow="dataRow"></filterdata>
                                <div class="el__close-btn" @click="isActive = false, selected=undefined"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="{el: true, sketchyThick: true, active:3 == selected}"  >
                    <div class="el__overflow">
                        <div class="el__inner">
                            <div class="el__bg"></div>
                            <div class="el__preview-cont" @click="valiStep2">
                                <h2>MATCH YOUR TITLES</h2>
                            </div>
                            <div class="el__content">
                                <matchingcolumns :allTitles="allTitles" :filteredData1="filteredData1" ></matchingcolumns>
                                <div class="el__close-btn" @click="isActive = false, selected=undefined" ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>



<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style>
    body{

        background-color: #807b78;

    }

    .sketchy {
        padding: 4rem 8rem;
        display: inline-block;
        border: 3px solid #ff9003;
        border-radius: 2% 6% 5% 4% / 1% 1% 2% 4%;
        /*text-transform: uppercase;*/
        letter-spacing: 0.3ch;
        background: transparent;
        position: relative;

    &::before {
         content: '';
         border: 2px solid #ff9003;
         display: block;
         width: 100%;
         height: 100%;
         position: absolute;
         top: 50%;
         left: 50%;
         transform: translate3d(-50%, -50%, 0) scale(1.015) rotate(0.5deg);
         border-radius: 1% 1% 2% 4% / 2% 6% 5% 4%;
     }
    }

    .sketchyThick {
        display: inline-block;
        border: 0.5vw solid #ff9003;
        /*padding: calc(vw * 0.5rem);*/
        border-radius: 2% 6% 5% 4% / 1% 1% 2% 1%;
        /*text-transform: uppercase;*/
        /*letter-spacing: 0.3ch;*/
        background: transparent;
        position: relative;

    }


    h1{
        color: #9799a8;
        text-transform: uppercase;
        font-size: 68vw;
        text-align: center;
    }

    h2 {
        font-family:'Nunito', sans-serif;
        color: #fff;
        text-transform: uppercase;
        text-align: center;
        font-size: 3vw;
        word-spacing: 999999999px;
        font-weight:1000 ;
    }



    h3{
        color: #ff9003;
        text-align: center;
        font-family: 'Yellowtail', cursive;
        font-size: 3vw;
    }
    h4{
        color: #fff;
        text-align: center;
        font-family:'Nunito', sans-serif;
        font-size: 3vw;
    }

    *, *:before, *:after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .cont {
        position: relative;
        overflow: hidden;
        height: 100vh;
        padding: 80px 70px;
    }
    .cont__inner {
        position: relative;
        height: 100%;
    }
    /* .cont__inner:hover .el__bg:after {
      opacity: 1;
    } */

    .el {
        position: absolute;
        left: 0;
        top: 0;
        width: 19.2%;
        height: 100%;
        background: #252525;

        /*   THESE WILL CHANGE THE COMING BACK MOTION */
        transition: width 0.7s, opacity 0.6s 0.7s, z-index 0s 1.3s, -webkit-transform 0.6s 0.7s;
        transition: transform 0.6s 0.7s, width 0.7s, opacity 0.6s 0.7s, z-index 0s 1.3s;
        transition: transform 0.6s 0.7s, width 0.7s, opacity 0.6s 0.7s, z-index 0s 1.3s, -webkit-transform 0.6s 0.7s;
        will-change: transform, width, opacity;
    }
    .el:hover:not(.active):hover {
        border: 0.5vw solid #fb570f;
        background-color: #393546;
    }

    .el__overflow {
        overflow: hidden;
        position: relative;
        height: 100%;
    }
    .el__inner {
        overflow: hidden;
        position: relative;
        height: 100%;

    }

    .el__bg {
        position: relative;
        width: calc(100vw - 140px);
        height: 100%;
    }


    .el__preview-cont {
        z-index: 2;
        display: flex;
        justify-content: center;
        align-items: center;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        /*   THIS WILL TRANSITION "SECTION 1" String  on its way back*/
        transition: all 0.3s 1.2s;
    }
    /* FIRST LOAD ANIMATION ON TEXT */
    .cont.inactive .el__preview-cont {
        opacity: 0;
        -webkit-transform: translateY(10px);
        transform: translateY(10px);
    }
    /* ANIMATION TEXT AFTER CLOSE */
    .cont.elActive .el__preview-cont {
        opacity: 0;
        -webkit-transform: translateY(30px);
        transform: translateY(30px);
        transition: all 0.5s;
    }


    .el__content {
        z-index: -1;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        padding: 30px;
        opacity: 0;
        pointer-events: none;

    }
    .el.active .el__content {
        z-index: 2;
        opacity: 1;
        pointer-events: auto;

    }

    /* THE CLOSE BUTTON */
    .el__close-btn {
        z-index: -1;
        position: absolute;
        right: 10px;
        top: 10px;
        width: 60px;
        height: 60px;
        opacity: 0;
        pointer-events: none;
        transition: all 0s 0.45s;
        cursor: pointer;
    }
    .el.active .el__close-btn {
        z-index: 5;
        opacity: 1;
        pointer-events: auto;
        transition: all 0s 1.4s;
    }
    .el__close-btn:before, .el__close-btn:after {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 8px;
        margin-top: -4px;
        background: #fff;
        opacity: 0;
        transition: opacity 0s;
    }
    .el.active .el__close-btn:before, .el.active .el__close-btn:after {
        opacity: 1;
    }
    .el__close-btn:before {
        -webkit-transform: rotate(45deg) translateX(100%);
        transform: rotate(45deg) translateX(100%);
    }
    .el.active .el__close-btn:before {
        transition: all 0.3s 1.4s cubic-bezier(0.72, 0.09, 0.32, 1.57);
        -webkit-transform: rotate(45deg) translateX(0);
        transform: rotate(45deg) translateX(0);
    }
    .el__close-btn:after {
        -webkit-transform: rotate(-45deg) translateX(100%);
        transform: rotate(-45deg) translateX(100%);
    }
    .el.active .el__close-btn:after {
        transition: all 0.3s 1.55s cubic-bezier(0.72, 0.09, 0.32, 1.57);
        -webkit-transform: rotate(-45deg) translateX(0);
        transform: rotate(-45deg) translateX(0);
    }
    /* CHILD 1 */
    .el:nth-child(1) {
        /*   -webkit-transform: translate3d(0%, 0, 0);
                  transform: translate3d(0%, 0, 0); */
        /*   -webkit-transform-origin: 50% 50%;
                  transform-origin: 50% 50%; */
    }
    .cont.elActive .el:nth-child(1):not(.active) {
        /*   -webkit-transform: scale(0.5) translate3d(0%, 0, 0);
                  transform: scale(0.5) translate3d(0%, 0, 0);
          opacity: 0;
          transition: opacity 0.95s, -webkit-transform 0.95s; */
        /*   transition: transform 0.95s, opacity 0.95s;
          transition: transform 0.95s, opacity 0.95s, -webkit-transform 0.95s; */
    }
    /* .el:nth-child(1) .el__inner {
      transition-delay: 0s;
    } */
    .el:nth-child(1) .el__bg {
        /*   -webkit-transform: translate3d(0%, 0, 0);
                  transform: translate3d(0%, 0, 0); */
    }
    .el:nth-child(1) .el__bg {
        transition-delay: 0s;
        /*background-image: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/142996/onepgscr-3.jpg");*/
    }
    /* CHILD 2 */
    .el:nth-child(2) {
        -webkit-transform: translate3d(105.2083333333%, 0, 0);
        transform: translate3d(200.2083333333%, 0, 0);
        -webkit-transform-origin: 155.2083333333% 50%;
        transform-origin: 155.2083333333% 50%;
    }
    .cont.elActive .el:nth-child(2):not(.active) {
        -webkit-transform: scale(0.5) translate3d(105.2083333333%, 0, 0);
        transform: scale(0.5) translate3d(105.2083333333%, 0, 0);
        opacity: 0;
        transition: opacity 0.95s, -webkit-transform 0.95s;
        transition: transform 0.95s, opacity 0.95s;
        transition: transform 0.95s, opacity 0.95s, -webkit-transform 0.95s;
    }
    /* .el:nth-child(2) .el__inner {
      transition-delay: 0.1s;
    } */
    /* .el:nth-child(2) .el__bg {
      -webkit-transform: translate3d(-19.2%, 0, 0);
              transform: translate3d(-19.2%, 0, 0);
     } */
    .el:nth-child(2) .el__bg {
        transition-delay: 0.1s;
        /*background-image: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/142996/onepgscr-4.jpg");*/
    }
    /* CHILD 3 */
    .el:nth-child(3) {
        -webkit-transform: translate3d(210.4166666667%, 0, 0);
        transform: translate3d(400.4166666667%, 0, 0);
        -webkit-transform-origin: 260.4166666667% 50%;
        transform-origin: 260.4166666667% 50%;
    }
    .cont.elActive .el:nth-child(3):not(.active) {
        -webkit-transform: scale(0.5) translate3d(210.4166666667%, 0, 0);
        transform: scale(0.5) translate3d(210.4166666667%, 0, 0);
        opacity: 0;
        transition: opacity 0.95s, -webkit-transform 0.95s;
        transition: transform 0.95s, opacity 0.95s;
        transition: transform 0.95s, opacity 0.95s, -webkit-transform 0.95s;
    }
    /* .el:nth-child(3) .el__inner {
      transition-delay: 0.2s;
    } */
    /* .el:nth-child(3) .el__bg {
      -webkit-transform: translate3d(-38.4%, 0, 0);
              transform: translate3d(-38.4%, 0, 0);
    } */
    /* .el:nth-child(3) .el__bg:before {
      transition-delay: 0.2s;
      background-image: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/142996/onepgscr-5.jpg");
    } */


    .el.active {
        z-index: 1;
        width: 100%;
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        transition: width 0.7s 0.7s, z-index 0s, -webkit-transform 0.6s;
        transition: transform 0.6s, width 0.7s 0.7s, z-index 0s;
        transition: transform 0.6s, width 0.7s 0.7s, z-index 0s, -webkit-transform 0.6s;
    }

    .el.active .el__bg {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        transition: -webkit-transform 0.6s;
        transition: transform 0.6s;
        transition: transform 0.6s, -webkit-transform 0.6s;
    }
    /* .el.active .el__bg:before {
    /*   transition-delay: 0.6s;
      -webkit-transform: scale(1.1);
              transform: scale(1.1);
     } */
</style>
<script>

    export default {
        props:['csvParse'],
        mounted() {
            console.log('BigParent mounted.');
            setTimeout(() => this.isInActive=false, 50);
        },
        data() {
            return {
                notReady: false,
                isActive: false,
                isInActive: true,
                selected: undefined,
                show:false,
                allTitles:[],
                actualData:[],
                dataCol:{},
                dataRow:{},
                filteredData1: []
            }
        },

        methods:{
            valiStep1(){
                if(this.allTitles.length > 0){
              this.selected = 2
                this.isActive = true
            }else{
                    this.notReady=true
                    setTimeout(() => this.notReady=false, 5000);
                }
            },
            valiStep2(){
                if(this.filteredData1.length > 0){
                    this.selected = 3
                    this.isActive = true
                }else{
                    this.notReady=true
                    setTimeout(() => this.notReady=false, 5000);
                }
            },
                navigate(value){
                    // this.isActive = false
                    this.selected = 2
                },
            navigate2(value){
                if(this.filteredData1.length > 0) {
                    // this.isActive = false
                    this.selected = 3
                }
            },

            csvFileText(obj){
                let allData = obj
                let newData = allData.replace(/,,/g, '," ",');
                let newerData = newData.replace(/,,/g, '," ",')
                var res = newerData.split("\n");
                var tot = res[0].split(",");
                var totRow = []
                this.allTitles = tot;
                var y
                for(y = 0; y < res.length; y++){
                    totRow.push(res[y].match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g));
                }
                this.dataRow = totRow;
// TURNING ROWS INTO COLUMNS
                let newObjCol = {};
                tot.forEach(title => {
                    newObjCol[title] = [];
                })
                res.shift();
                res.forEach(row => {
                    let arr = row.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g)
                    tot.forEach((title, i) => {
                        newObjCol[title].push(arr[i]);
                    });
                })
                this.dataCol = newObjCol
                return
            },
            filteredData(obj){
                this.filteredData1 = obj
            }
        }
    }
</script>
