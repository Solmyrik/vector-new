const quizElements = document.querySelectorAll('.quiz__item');
const percentItem = document.querySelector('.quiz__progres');
const quizNumber = document.querySelector('.quiz__number span');
const quizArray = [];
const quizeArray = [];
let index = 1;

const stepMibile = () => {
  const body = document.querySelector('.quiz__body');
  const mobile = document.querySelector('.quiz__mobile');

  body.style.display = 'none';
  mobile.style.display = 'block';
};

const percent = () => {
  const heightItems = quizElements.length;
  let current = parseInt((100 / heightItems) * (index + 1));
  percentItem.style.width = current + '%';
  index = index + 1;
  quizNumber.textContent = index;
};

const quizStep = (e) => {
  let currentAnswer = '';
  let currentQuestion = '';
  const current = e.target;

  currentQuestion = e.currentTarget.querySelector('.quiz__name').textContent;

  if (current.className === 'quiz__elements') return;

  if (index <= 3) {
    if (current.classList.contains('quiz__value')) {
      currentAnswer = current.textContent;
    }

    if (current.classList.contains('quiz__radio')) {
      currentAnswer = current.nextElementSibling.textContent;
    }

    if (current.classList.contains('quiz__element')) {
      const currentValue = current.querySelector('.quiz__value');
      currentAnswer = currentValue.textContent;
    }

    e.currentTarget.classList.remove('active');
    e.currentTarget.nextElementSibling.classList.add('active');

    quizArray.push(`${currentQuestion}: ${currentAnswer}`);
    percent();
  } else {
    stepMibile();
    console.log(quizArray);
  }
};

quizElements.forEach((quizContainer) => {
  quizContainer.addEventListener('click', quizStep);
});

//////////////////

const quizeElements = document.querySelectorAll('.quize__item');
const percenteItem = document.querySelector('.quize__progres');
const quizeNumber = document.querySelector('.quize__number span');
let indexE = 1;

const stepeMibile = () => {
  const body = document.querySelector('.quize__body');
  const mobile = document.querySelector('.quize__mobile');

  body.style.display = 'none';
  mobile.style.display = 'block';
};

const percente = () => {
  const heightItems = quizeElements.length;
  let current = parseInt((100 / heightItems) * (indexE + 1));
  percenteItem.style.width = current + '%';
  indexE = indexE + 1;
  quizeNumber.textContent = indexE;
};

const quizeStep = (e) => {
  let currentAnswer = '';
  let currentQuestion = '';
  const current = e.target;

  currentQuestion = e.currentTarget.querySelector('.quize__name').textContent;

  if (current.className === 'quize__elements') return;

  if (indexE <= 3) {
    if (current.classList.contains('quize__value')) {
      currentAnswer = current.textContent;
    }

    if (current.classList.contains('quize__radio')) {
      currentAnswer = current.nextElementSibling.textContent;
    }

    if (current.classList.contains('quize__element')) {
      const currentValue = current.querySelector('.quize__value');
      currentAnswer = currentValue.textContent;
    }

    e.currentTarget.classList.remove('active');
    e.currentTarget.nextElementSibling.classList.add('active');
    quizeArray.push(`${currentQuestion}: ${currentAnswer}`);
    percente();
  } else {
    stepeMibile();
    console.log(quizeArray);
  }
};

quizeElements.forEach((quizContainer) => {
  quizContainer.addEventListener('click', quizeStep);
});

const sliderArrayM = ['1b.webp', '2b.webp', '3b.webp', '4b.webp'];

function galleryM() {
  const container = document.querySelector('.production__left');
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
        GalleryNavigarionM(indexActive, 'next');
      }
      if (e.target.className === 'img-arrow-next') {
        GalleryNavigarionM(indexActive, 'next');
      }
      if (e.target.className === 'img-arrow-prev') {
        GalleryNavigarionM(indexActive, 'prev');
      }
      if (e.target.tagName !== 'IMG') {
        popup.classList.remove('active');
      }
    };
  }
}

function GalleryNavigarionM(index, direction) {
  const startIndex = index.indexOf('k/');
  const currentItem = index.slice(startIndex + 2);

  currentIndex = sliderArrayM.indexOf(currentItem);

  if (direction === 'next' && currentIndex < sliderArrayM.length - 1) {
    document.querySelector('.gallery__popup img').src = `${index.slice(0, startIndex + 2)}${
      sliderArrayM[currentIndex + 1]
    }`;
    indexActive = `${index.slice(0, startIndex + 2)}${sliderArrayM[currentIndex + 1]}`;
  }
  if (direction === 'prev' && currentIndex > 0) {
    document.querySelector('.gallery__popup img').src = `${index.slice(0, startIndex + 2)}${
      sliderArrayM[currentIndex - 1]
    }`;
    indexActive = `${index.slice(0, startIndex + 2)}${sliderArrayM[currentIndex - 1]}`;
  }
}
galleryM();
