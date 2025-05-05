document.addEventListener('DOMContentLoaded', () => {
  const createTweetBtn = document.getElementById('create-tweet-btn')
  const tweetPopup = document.getElementById('tweet-popup')
  const closePopup = document.getElementById('close-popup')

  if (createTweetBtn && tweetPopup && closePopup) {
    createTweetBtn.addEventListener('click', () => {
      tweetPopup.style.display = 'block'
    })

    closePopup.addEventListener('click', () => {
      tweetPopup.style.display = 'none'
    })

    tweetPopup.addEventListener('click', (e) => {
      if (e.target === tweetPopup) {
        tweetPopup.style.display = 'none'
      }
    })
  }
})
