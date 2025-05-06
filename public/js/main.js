document.addEventListener('DOMContentLoaded', () => {
  // Hamburger menu for sidebar
  const hamburger = document.getElementById('hamburger')
  const sidebar = document.getElementById('sidebar')

  if (hamburger && sidebar) {
    hamburger.addEventListener('click', () => {
      console.log('lol')
      hamburger.classList.toggle('active')
      sidebar.classList.toggle('active')
    })
  }

  // Popup for creating tweet
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
