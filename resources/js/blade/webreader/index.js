console.log("epub");
import { Book, Rendition } from "epubjs";
import {
  selectListener,
  clickListener,
  swipListener,
  wheelListener,
  keyListener,
} from "./listener/listener";
import { dark, tan, defaultStyle } from "./themes";

var book = {};
var rendition = {};
var toc = [];
var progress;

let prevPageBtn = document.getElementById("prevPage");
prevPageBtn.addEventListener("click", prevPage);
let nextPageBtn = document.getElementById("nextPage");
nextPageBtn.addEventListener("click", nextPage);

let firstPageBtn = document.getElementById("firstPage");
firstPageBtn.addEventListener("click", firstPage);
let lastPageBtn = document.getElementById("lastPage");
lastPageBtn.addEventListener("click", lastPage);

function contentStyle(rendition) {
  let contents = rendition.getContents();
  return contents.forEach((content) => {
    console.log(content);
    content.addStylesheetRules({});
  });
}

async function createEpub() {
  let epubPath = document.getElementById("epub_path");
  const path = epubPath.textContent;

  let info = {
    toc: {},
    lastOpen: null,
    path,
    highlights: [],
  };
  //   let toc = info.toc;
  info.lastOpen = new Date().getTime();
  //   let buble = $refs.bubleMenu;
  book = new Book(info.path);

  rendition = new Rendition(book, {
    width: "100%",
    height: "100%",
  });
  let flipPage = () => {
    if (direction === "next") nextPage();
    else if (direction === "prev") prevPage();
  };
  let toggleBuble = () => {
    if (event === "cleared") {
      // hide buble
      buble.hide();
      return;
    }
    buble.setProps(react, text, cfiRange);
    isBubleVisible = true;
  };
  rendition.on("rendered", (e, iframe) => {
    iframe.iframe.contentWindow.focus();
    clickListener(iframe.document, rendition, flipPage);
    selectListener(iframe.document, rendition, toggleBuble);
    swipListener(iframe.document, flipPage);
    wheelListener(iframe.document, flipPage);
    keyListener(iframe.document, flipPage);
  });
  rendition.on("relocated", (location) => {
    info.lastCfi = location.start.cfi;
    progress = book.locations.percentageFromCfi(location.start.cfi);
    sliderValue = Math.floor(progress * 10000) / 100;
  });
  let applyStyle = contentStyle(rendition);
  await rendition.hooks.content.register(applyStyle || {});

  book.ready
    .then((e) => {
      let meta = book.package.metadata;
      let title = meta.title;
      // let titleTag = document.getElementsByTagName("title");
      // titleTag.item(0).textContent = `${title} ${titleTag.item(0).textContent}`;
      book.locations.load(1);
    })
    .then(() => {
      rendition.attachTo(document.getElementById("reader"));
      rendition.display();
      rendition.themes.registerRules("dark", dark);
      rendition.themes.registerRules("tan", tan);
      rendition.themes.registerRules("default", defaultStyle);
      rendition.ready = true;
      let theme = theme;
      rendition.themes.select(theme);
      rendition.start();
    })
    .then(() => {
      info.highlights.forEach((cfiRange) => {
        rendition.annotations.highlight(cfiRange);
      });
    })
    .then(() => {
      toc = book.navigation.toc;
      // console.log(rendition.book.spine.items);
      // console.log(toc);
      // let _flattenedToc = (function flatten(items) {
      //   return [].concat(
      //     ...items.map((item) => [item].concat(...flatten(item.children)))
      //   );
      // })(toc);

      // _flattenedToc.sort((a, b) => {
      //   return a.percentage - b.percentage;
      // });
      setToc();
    });
}

function prevPage() {
  try {
    rendition.prev();
    console.clear();
  } catch (error) {}
}
function nextPage() {
  try {
    rendition.next();
    // console.clear();
    console.log(rendition);
  } catch (error) {}
}

function firstPage() {
  try {
    rendition.display(0);
    console.clear();
  } catch (error) {}
}
function lastPage() {
  try {
    console.log(book.spine.length);
    rendition.display(book.spine.length - 1);
    console.clear();
  } catch (error) {}
}

function setToc() {
  let tocBlock = document.getElementById("toc");
  console.log(rendition.book);
  toc.forEach((el, key) => {
    tocBlock.innerHTML += `<li id="${el.id} chapter-${key}" data-chapter="${key}" class="toc-item cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white group flex links-center px-2 py-2 text-sm font-medium rounded-md my-1 justify-between">${el.label}</li>`;
  });

  let tocItem = document.getElementsByClassName("toc-item");
  for (let index in tocItem) {
    if (index <= tocItem.length) {
      tocItem[index].addEventListener("click", setChapter);
    }
  }
}

function setChapter() {
  let chapter = this.dataset.chapter;
  rendition.display(item.cfi || item.href);
}

createEpub();
