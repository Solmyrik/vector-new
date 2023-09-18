const popupButton = document.querySelector('.popup-form__button');
const titlePage = document.title;

popupButton.addEventListener('click', onSubmit);

async function onSubmit(e) {
  e.preventDefault();
  const phone = document.querySelector('.popup-phone');
  const name = document.querySelector('.popup-name');
  const checkBox = document.querySelector('.popup-form__checkbox');
  const validate = onValidate(phone.value, checkBox.checked);
  if (validate === true) {
    const oneBody = document.querySelector('.popup-form__body_one');
    const twoBody = document.querySelector('.popup-form__body_two');
    const number = document.querySelector('.popup-form__number');

    oneBody.style.display = 'none';
    number.textContent = phone.value;
    twoBody.style.display = 'block';
    ym(94023610, 'reachGoal', 'Lead_terraces');

    let formData = new FormData();
    formData.append('#1', phone.value);
    formData.append('#2', name.value);
    formData.append('страница:', titlePage);
    let responce = await fetch('sendmail.php', {
      method: 'POST',
      body: formData,
    });
  }
}

function onValidate(phone, checkBox) {
  if (phone.length < 18 || checkBox === false) {
    alert('Заполните форму');
    return false;
  }
  return true;
}

const quizButton = document.querySelector('.mobile-quiz__button');

quizButton.addEventListener('click', onSubmitQuiz);

async function onSubmitQuiz(e) {
  e.preventDefault();
  const phone = document.querySelector('.quiz-phone');
  const name = document.querySelector('.quiz-name');
  const checkBox = document.querySelector('.mobile-quiz__checkbox');
  const validate = onValidate(phone.value, checkBox.checked);
  if (validate === true) {
    const oneBody = document.querySelector('.mobile-quiz__body_one');
    const twoBody = document.querySelector('.mobile-quiz__body_two');
    const number = document.querySelector('.mobile-quiz__number');

    oneBody.style.display = 'none';
    number.textContent = phone.value;
    twoBody.style.display = 'block';
    ym(94023610, 'reachGoal', 'Lead_terraces');

    let formData = new FormData();
    formData.append('страница:', titlePage);
    formData.append('#1', phone.value);
    formData.append('#2', name.value);
    formData.append('#3', quizArray[0]);
    formData.append('#4', quizArray[1]);
    formData.append('#5', quizArray[2]);
    formData.append('#6', quizArray[3]);
    formData.append('#7', quizArray[4]);
    formData.append('#8', quizArray[5]);
    formData.append('#9', quizArray[6]);
    formData.append('#10', quizArray[7]);
    let responce = await fetch('sendmail.php', {
      method: 'POST',
      body: formData,
    });
  }
}

/////

const quizeButton = document.querySelector('.mobile-quize__button');

quizeButton.addEventListener('click', onSubmitQuize);

async function onSubmitQuize(e) {
  e.preventDefault();
  const phone = document.querySelector('.quize-phone');
  const name = document.querySelector('.quize-name');
  const checkBox = document.querySelector('.mobile-quize__checkbox');
  const validate = onValidate(phone.value, checkBox.checked);
  if (validate === true) {
    const oneBody = document.querySelector('.mobile-quize__body_one');
    const twoBody = document.querySelector('.mobile-quize__body_two');
    const number = document.querySelector('.mobile-quize__number');

    oneBody.style.display = 'none';
    number.textContent = phone.value;
    twoBody.style.display = 'block';
    ym(94023610, 'reachGoal', 'Lead_terraces');

    let formData = new FormData();
    formData.append('страница:', titlePage);
    formData.append('#1', phone.value);
    formData.append('#2', name.value);
    formData.append('#3', quizeArray[0]);
    formData.append('#4', quizeArray[1]);
    formData.append('#5', quizeArray[2]);
    formData.append('#6', quizeArray[3]);
    formData.append('#7', quizeArray[4]);
    formData.append('#8', quizeArray[5]);
    formData.append('#9', quizeArray[6]);
    formData.append('#10', quizeArray[7]);
    let responce = await fetch('sendmail.php', {
      method: 'POST',
      body: formData,
    });
  }
}
