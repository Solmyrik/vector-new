const iconMenu = document.querySelector('.header__burger');
const menuBody = document.querySelector('.header__body');
if (iconMenu) {
  iconMenu.addEventListener('click', function (e) {
    document.body.classList.toggle('_lock');
    iconMenu.classList.toggle('_active');
    menuBody.classList.toggle('_active');
  });
}

const listMenu = document.querySelector('.menu__list');
listMenu.addEventListener('click', (e) => {
  if (e.target.className === 'menu__link') {
    document.body.classList.remove('_lock');
    iconMenu.classList.remove('_active');
    menuBody.classList.remove('_active');
  }
});

function ibg() {
  let ibg = document.querySelectorAll('.ibg');
  for (var i = 0; i < ibg.length; i++) {
    if (ibg[i].querySelector('img')) {
      ibg[i].style.backgroundImage = 'url(' + ibg[i].querySelector('img').getAttribute('src') + ')';
    }
  }
}
ibg();

////////
const sliderArray = [
  '1slide/1b.webp',
  '1slide/2b.webp',
  '1slide/3b.webp',
  '1slide/4b.webp',
  '2slide/1b.webp',
  '2slide/2b.webp',
  '2slide/3b.webp',
  '2slide/4b.webp',
  '3slide/1b.webp',
  '3slide/2b.webp',
  '3slide/3b.webp',
  '3slide/4b.webp',
  '4slide/1b.webp',
  '4slide/2b.webp',
  '4slide/3b.webp',
  '4slide/4b.webp',
  '5slide/1b.webp',
  '5slide/2b.webp',
  '5slide/3b.webp',
  '5slide/4b.webp',
];

const sliderArrayF = [
  '1slide/1b.webp',
  '1slide/2b.webp',
  '1slide/3b.webp',
  '1slide/4b.webp',
  '2slide/1b.webp',
  '2slide/2b.webp',
  '2slide/3b.webp',
  '2slide/4b.webp',
  '3slide/1b.webp',
  '3slide/2b.webp',
  '3slide/3b.webp',
  '3slide/4b.webp',
  '4slide/1b.webp',
  '4slide/2b.webp',
  '4slide/3b.webp',
  '4slide/4b.webp',
  '5slide/1b.webp',
  '5slide/2b.webp',
  '5slide/3b.webp',
  '5slide/4b.webp',
  '6slide/1b.webp',
  '6slide/2b.webp',
  '6slide/3b.webp',
  '6slide/4b.webp',
  '7slide/1b.webp',
  '7slide/2b.webp',
  '7slide/3b.webp',
  '7slide/4b.webp',
];

let indexActive = '';

const workF = document.querySelector('.workF');
const work = document.querySelector('.work');

function gallery() {
  const container = document.querySelector('.swiper-wrapper');
  const popup = document.querySelector('.gallery__popup');

  if (popup) {
    container.addEventListener('click', (e) => {
      if (e.target.classList.contains('ibg')) {
        popup.classList.add('active');
        const index = e.target.childNodes[1].getAttribute('src').indexOf('.webp');
        const current =
          e.target.childNodes[1].getAttribute('src').slice(0, index) +
          'b' +
          e.target.childNodes[1].getAttribute('src').slice(index);

        indexActive = current;

        document.querySelector('.gallery__popup img').src = current;
      }
    });

    document.querySelector('.gallery__popup').onclick = (e) => {
      if (e.target.className === 'gallery__img') {
        if (workF) {
          GalleryNavigarionF(indexActive, 'next');
        } else {
          GalleryNavigarion(indexActive, 'next');
        }
      }
      if (e.target.className === 'img-arrow-next') {
        if (workF) {
          GalleryNavigarionF(indexActive, 'next');
        } else {
          GalleryNavigarion(indexActive, 'next');
        }
      }
      if (e.target.className === 'img-arrow-prev') {
        if (workF) {
          GalleryNavigarionF(indexActive, 'prev');
        } else {
          GalleryNavigarion(indexActive, 'prev');
        }
      }
      if (e.target.tagName !== 'IMG') {
        popup.classList.remove('active');
      }
    };
  }
}

function GalleryNavigarionF(index, direction) {
  const startIndex = index.indexOf('k/');
  const currentItem = index.slice(startIndex + 2);

  currentIndex = sliderArrayF.indexOf(currentItem);

  if (direction === 'next' && currentIndex < sliderArrayF.length - 1) {
    document.querySelector('.gallery__popup img').src = `${index.slice(0, startIndex + 2)}${
      sliderArrayF[currentIndex + 1]
    }`;
    indexActive = `${index.slice(0, startIndex + 2)}${sliderArrayF[currentIndex + 1]}`;
  }
  if (direction === 'prev' && currentIndex > 0) {
    document.querySelector('.gallery__popup img').src = `${index.slice(0, startIndex + 2)}${
      sliderArrayF[currentIndex - 1]
    }`;
    indexActive = `${index.slice(0, startIndex + 2)}${sliderArrayF[currentIndex - 1]}`;
  }
}

function GalleryNavigarion(index, direction) {
  const startIndex = index.indexOf('k/');
  const currentItem = index.slice(startIndex + 2);

  currentIndex = sliderArray.indexOf(currentItem);

  if (direction === 'next' && currentIndex < sliderArray.length - 1) {
    document.querySelector('.gallery__popup img').src = `${index.slice(0, startIndex + 2)}${
      sliderArray[currentIndex + 1]
    }`;
    indexActive = `${index.slice(0, startIndex + 2)}${sliderArray[currentIndex + 1]}`;
  }
  if (direction === 'prev' && currentIndex > 0) {
    document.querySelector('.gallery__popup img').src = `${index.slice(0, startIndex + 2)}${
      sliderArray[currentIndex - 1]
    }`;
    indexActive = `${index.slice(0, startIndex + 2)}${sliderArray[currentIndex - 1]}`;
  }
}

if (work || workF) {
  gallery();
}

// reviews
const reviewsAll = document.querySelector('.reviews__all');
const reviewsItems = document.querySelectorAll('.reviews__item');

if (reviewsAll) {
  reviewsAll.addEventListener('click', (e) => {
    reviewsItems.forEach((r) => {
      r.classList.remove('none');
    });
    reviewsAll.style.display = 'none';
  });
}

//policy
const policyBlock = document.querySelector('.policy');
const policyLink = document.querySelectorAll('.policy-link');

policyLink.forEach((policy) => {
  policy.addEventListener('click', (e) => {
    policyBlock.classList.add('show');
    document.querySelector('.policy').onclick = (e) => {
      if (e.target.className === 'policy__wrapper' || e.target.className === 'policy__close') {
        policyBlock.classList.remove('show');
      }
    };
  });
});

//video
const video1 = document.querySelector('.video-1');
const video2 = document.querySelector('.video-2');
const video3 = document.querySelector('.video-3');

setTimeout(() => {
  video1.src = 'https://www.youtube.com/embed/EIoX2TxPtpc';
  video2.src = 'https://www.youtube.com/embed/H3tagtO7SJE';
  video3.src = 'https://www.youtube.com/embed/5pEA65jD5ZA';
}, 7000);

////

const mytelOne = document.getElementById('mytel-1');
const mytelTwo = document.getElementById('mytel-2');
const mytelThree = document.getElementById('mytel-3');

mytelOne.addEventListener('click', function () {
  if (mytelOne.value.length === 4) {
    mytelOne.setSelectionRange(4, 5);
  }
});
mytelTwo.addEventListener('click', function () {
  if (mytelTwo.value.length === 4) {
    mytelTwo.setSelectionRange(4, 5);
  }
});
mytelThree.addEventListener('click', function () {
  if (mytelThree.value.length === 4) {
    mytelThree.setSelectionRange(4, 5);
  }
});

const telegram1 = document.querySelector('.telegram1');
const whatsapp1 = document.querySelector('.whatsapp1');
const whatsapp2 = document.querySelector('.whatsapp2');
const telegram2 = document.querySelector('.telegram2');
if (telegram1) {
  telegram1.addEventListener('click', (e) => {
    ym(94023610, 'reachGoal', 'Lead_tg_terraces');
  });
  telegram2.addEventListener('click', (e) => {
    ym(94023610, 'reachGoal', 'Lead_tg_terraces');
  });
  whatsapp1.addEventListener('click', (e) => {
    ym(94023610, 'reachGoal', 'Lead_wp_terraces');
  });
  whatsapp2.addEventListener('click', (e) => {
    ym(94023610, 'reachGoal', 'Lead_wp_terraces');
  });
}

const whatsapp3 = document.querySelector('.whatsapp3');
const telegram3 = document.querySelector('.telegram3');

if (telegram3) {
  telegram3.addEventListener('click', (e) => {
    ym(94023610, 'reachGoal', 'Lead_tg_terraces');
  });
  whatsapp3.addEventListener('click', (e) => {
    ym(94023610, 'reachGoal', 'Lead_wp_terraces');
  });
}
