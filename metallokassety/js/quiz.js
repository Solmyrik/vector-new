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

  if (index <= 8) {
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

  if (indexE <= 8) {
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
