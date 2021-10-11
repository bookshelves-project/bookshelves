import { Book, Rendition } from "epubjs";
import { functions } from "lodash";
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
var isReady = false;
var navigationOptions = document.getElementById("navigation-options");

var disableNavTutoBtn = document.getElementById("disable-nav-tuto");
disableNavTutoBtn.addEventListener("click", disableNavTuto);

// first webreader usage
if (localStorage.getItem("nav-tuto") === null) {
  //
  // tuto is disable
} else if (localStorage.getItem("nav-tuto") === "false") {
  hideNavTuto();
}

function contentStyle(rendition) {
  let contents = rendition.getContents();
  return contents.forEach((content) => {
    content.addStylesheetRules({});
  });
}

async function initBook() {
  setupBook();
  book.ready.then((e) => {
    loadBook();
    setReady();
  });
}

/**
 * Get Book from path
 * Init Book and Rendition
 */
async function setupBook() {
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
    // ignoreClass?: string,
    manager: "default",
    // view?: string | Function | object,
    // flow?: string,
    // layout?: string,
    spread: "always",
    // minSpreadWidth?: number,
    stylesheet: "/assets/css/blade/webreader.css",
    // resizeOnOrientationChange?: boolean,
    // script?: string,
    infinite: true,
    // overflow?: string,
    // snap?: boolean | object,
    // defaultDirection?: string,
  });
}

/**
 * Load book
 */
async function loadBook() {
  // let flipPage = () => {
  //   if (direction === "next") nextPage();
  //   else if (direction === "prev") prevPage();
  // };
  // let toggleBuble = () => {
  //   if (event === "cleared") {
  //     // hide buble
  //     buble.hide();
  //     return;
  //   }
  //   buble.setProps(react, text, cfiRange);
  //   isBubleVisible = true;
  // };
  // rendition.on("rendered", (e, iframe) => {
  //   iframe.iframe.contentWindow.focus();
  //   clickListener(iframe.document, rendition, flipPage);
  //   selectListener(iframe.document, rendition, toggleBuble);
  //   swipListener(iframe.document, flipPage);
  //   wheelListener(iframe.document, flipPage);
  //   keyListener(iframe.document, flipPage);
  // });
  // rendition.on("relocated", (location) => {
  //   info.lastCfi = location.start.cfi;
  //   progress = book.locations.percentageFromCfi(location.start.cfi);
  //   sliderValue = Math.floor(progress * 10000) / 100;
  // });
  // let applyStyle = contentStyle(rendition);
  // await rendition.hooks.content.register(applyStyle || {});

  let meta = book.package.metadata;
  let title = meta.title;
  // let titleTag = document.getElementsByTagName("title");
  // titleTag.item(0).textContent = `${title} ${titleTag.item(0).textContent}`;
  book.locations.load(1);
}

/**
 * Attach iframe to HTML
 * Display iframe
 */
async function displayBook() {
  rendition.attachTo(document.getElementById("reader"));
  let cfi = book.locations.cfiFromPercentage(
    10 / book.locations.spine.items.length
  );
  var params =
    URLSearchParams &&
    new URLSearchParams(document.location.search.substring(1));
  var url =
    params && params.get("url") && decodeURIComponent(params.get("url"));
  var currentSectionIndex =
    params && params.get("loc") ? params.get("loc") : undefined;
  rendition.display(currentSectionIndex);
  // rendition.themes.registerRules("dark", dark);
  // rendition.themes.registerRules("tan", tan);
  rendition.themes.registerRules("default", defaultStyle);
  rendition.ready = true;
  let theme = theme;
  rendition.themes.select(theme);
  rendition.start();
}

/**
 * Set TOC
 */
async function setOptions() {
  // info.highlights.forEach((cfiRange) => {
  //   rendition.annotations.highlight(cfiRange);
  // });
  toc = book.navigation.toc;
  // let _flattenedToc = (function flatten(items) {
  //   return [].concat(
  //     ...items.map((item) => [item].concat(...flatten(item.children)))
  //   );
  // })(toc);

  // _flattenedToc.sort((a, b) => {
  //   return a.percentage - b.percentage;
  // });
  setToc();
}

/**
 * Set isReady when Book is loaded
 */
async function setReady() {
  isReady = true;

  let isReadyEl = document.getElementById("isReady");
  isReadyEl.innerHTML = `<button id="read" type="button" class="button">Read now</button>`;

  let readBtn = document.getElementById("read");
  readBtn.addEventListener("click", read);
}

function setToc() {
  let tocBlock = document.getElementById("toc");
  toc.forEach((el, key) => {
    tocBlock.innerHTML += `<li id="${el.id} chapter-${key}" data-chapter="${el.href}" class="toc-item cursor-pointer text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-700 hover:text-gray-800 dark:hover:text-white group flex links-center px-2 py-2 text-sm font-medium rounded-md my-1 justify-between">${el.label}</li>`;
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
  rendition.display(chapter);
}

function read() {
  let isReadyEl = document.getElementById("isReady");
  isReadyEl.innerHTML = "EPUB is ready";
  let descPart = document.getElementById("desc");
  descPart.classList.add("hidden");

  let bookNav = document.getElementById("book-nav");
  bookNav.classList.remove("hidden");

  book.ready
    .then(() => {
      displayBook();
    })
    .then(() => {
      setOptions();
    });
}

initBook();

let prevPageBtn = document.getElementById("prevPage");
prevPageBtn.addEventListener("click", prevPage);
let nextPageBtn = document.getElementById("nextPage");
nextPageBtn.addEventListener("click", nextPage);

let prevSidePageBtn = document.getElementById("leftBtn");
prevSidePageBtn.addEventListener("click", prevPage);
let centerPageBtn = document.getElementById("centerBtn");
centerPageBtn.addEventListener("click", toggleNavigationOptions);
let nextSidePageBtn = document.getElementById("rightBtn");
nextSidePageBtn.addEventListener("click", nextPage);

let firstPageBtn = document.getElementById("firstPage");
firstPageBtn.addEventListener("click", firstPage);
let lastPageBtn = document.getElementById("lastPage");
lastPageBtn.addEventListener("click", lastPage);

function prevPage() {
  try {
    rendition.prev();
    console.clear();
  } catch (error) {}
}
function nextPage() {
  try {
    rendition.next();
    console.clear();
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
    rendition.display(book.spine.length - 1);
    console.clear();
  } catch (error) {}
}

function hideNavTuto() {
  let tutoEl = document.getElementsByClassName("book-nav-tuto");
  while (tutoEl.length > 0) {
    tutoEl[0].parentNode.removeChild(tutoEl[0]);
  }

  let navBook = document.getElementsByClassName("nav-tuto");
  Object.keys(navBook).forEach(function (key) {
    navBook[key].classList.add("side-button");
    navBook[key].classList.remove("nav-tuto-color");
  });
}

function disableNavTuto() {
  localStorage.setItem("nav-tuto", false);
  hideNavTuto();
}

function toggleNavigationOptions() {
  navigationOptions.classList.toggle("hidden");
}
