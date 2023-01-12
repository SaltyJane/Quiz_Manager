// Nest all JS inside this, so that the DOM has completely loaded before
// I start messing around DOM elements
document.addEventListener('DOMContentLoaded', function () {
    // Target the hidden input on the add-quiz page
    const amtInput = document.querySelector('#question-amount');
    // set its value to the number of questions.
    // amtInput.setAttribute('value', `${num_questions}`);

    // Minimum amount of questions in a quiz is 3.
    let num_questions = amtInput.value;
    console.log(num_questions);

    // declare variables for the questions container and the add-question button
    const allQuestionsContainer = document.querySelector('#all-questions');
    const addQuestionBtn = document.querySelector('.add-another');

    // Add an event listener to the add question button to create new question inputs
    addQuestionBtn.addEventListener('click', function () {
        // if the 'add question' button was clicked, then the amt of questions increases
        num_questions++;
        createNewQuestion(num_questions);
        // set input to amount of questions
        amtInput.setAttribute('value', `${num_questions}`);
    });

    // function to create a new question
    function createNewQuestion(questionNum) {
        // create a new question contaier
        const container = document.createElement('div');
        container.classList.add('question-container');
        container.classList.add('card');
        container.classList.add('p-3');
        container.classList.add('m-3');

        // create a new title container
        const titleContainer = document.createElement('div');
        titleContainer.classList.add('form-group');
        titleContainer.classList.add('question-title');

        // create a label for the title
        const titleLabel = document.createElement('label');
        titleLabel.setAttribute('for', `Question${questionNum}`);
        titleLabel.innerText = `Question title`;

        // create the title input
        const titleInput = document.createElement('input');
        titleInput.classList.add('question-title');
        titleInput.setAttribute('type', 'text');
        titleInput.setAttribute('name', `Question${questionNum}`);
        titleInput.setAttribute('id', `Question${questionNum}`);
        titleInput.setAttribute('required', 'true');

        // append the title label and input to the title container.
        titleContainer.appendChild(titleLabel);
        titleContainer.appendChild(titleInput);
        // append the entire title area to the question container
        container.appendChild(titleContainer);

        // create the margin div for the answers
        const marginDiv = document.createElement('div');
        marginDiv.classList.add('ml-3');

        // loop through exactly 5 iterations to create answer inputs
        for (let i = 0; i < 5; i++) {
            const choiceContainer = document.createElement('div');
            choiceContainer.classList.add('form-group');

            let choiceLabel = '';
            let choiceInput = '';
            // answers 1-3 are mandatory
            if (i < 3) {
                // create a label for the answers
                choiceLabel = document.createElement('label');
                choiceLabel.setAttribute('for', `Question${questionNum}-choice${i + 1}`);
                // the first answer will be the correct one, so use an if statement to label appropriately
                if (i == 0) {
                    choiceLabel.innerText = `Correct answer`;
                } else {
                    choiceLabel.innerText = `Wrong answer ${i}`;
                }
                // create the input for answers 1-3 and set attributes
                choiceInput = document.createElement('input');
                choiceInput.setAttribute('type', 'text');
                choiceInput.setAttribute('name', `Question${questionNum}-choice${i + 1}`);
                choiceInput.setAttribute('id', `Question${questionNum}-choice${i + 1}`);
                choiceInput.setAttribute('required', 'true');
                // answers 4 and 5 are optional
            } else {
                // create label for answers 4 and 5
                choiceLabel = document.createElement('label');
                choiceLabel.setAttribute('for', `Question${questionNum}-choice${i + 1}`);
                choiceLabel.innerText = `(optional) Wrong answer ${i}`;

                // create the input for answers 4 and 5
                choiceInput = document.createElement('input');
                choiceInput.setAttribute('type', 'text');
                choiceInput.setAttribute('name', `Question${questionNum}-choice${i + 1}`);
                choiceInput.setAttribute('id', `Question${questionNum}-choice${i + 1}`);
            }

            // append the input and label to the form group
            choiceContainer.appendChild(choiceLabel);
            choiceContainer.appendChild(choiceInput);
            // append all answers to the div
            marginDiv.appendChild(choiceContainer);
        }
        // create a 'delete button' which will delete the question we just added
        // whilst I can create the button here, I cannot add its click event
        // until after this function, in its own which applies event delegation
        const deleteBtn = document.createElement('p');
        deleteBtn.classList.add('btn');
        deleteBtn.classList.add('btn-danger');
        deleteBtn.classList.add('delete-question');
        deleteBtn.innerText = `Delete this question`;
        deleteBtn.setAttribute('id', `${questionNum}`);

        // append everything we created in this function to the question container
        container.appendChild(marginDiv);
        container.appendChild(deleteBtn);
        allQuestionsContainer.appendChild(container);
    } // end addQuestion function


    // instead of adding the event listener to the delete button (which doesn't exist 
    // in the DOM yet because it was added dynamically), I am adding it to 
    // the parent of its parent (because its parent also doesn't exist yet).
    // this is called event delegation and it will check if the element clicked
    // was an element with the class 'delete-question'.
    allQuestionsContainer.addEventListener('click', e => {
        const { target } = e;
        // if the click was on the delete button, call the deleteQuestion function
        if (target.matches('.delete-question')) {
            deleteQuestion(target);
        }
    })

    // function to delete the parent element
    // of the given (clicked, in this case) element
    function deleteQuestion(e) {
        // reduce the number of questions by 1, and update the 
        // input which tracks the amount of questions in the quiz
        num_questions -= 1;
        amtInput.setAttribute('value', `${num_questions}`);
        e.parentElement.remove();
    }


});