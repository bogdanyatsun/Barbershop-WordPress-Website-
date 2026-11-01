/**
 * THE GENTLEMAN'S RESERVE - BESPOKE BARBERSHOP
 * Multi-Page Architecture: Form Validation, Content Upload, Lightbox, Performance Audit
 */

document.addEventListener('DOMContentLoaded', () => {

  /* -------------------------------------------------------------------------
     1. PAGE 1 (INDEX.HTML): OPT-IN BOOKING FORM ENGINE
     ------------------------------------------------------------------------- */
  const appointmentForm = document.getElementById('appointmentForm');

  if (appointmentForm) {
    const bookingSuccessModal = document.getElementById('bookingSuccessModal');
    const closeBookingSuccess = document.getElementById('closeBookingSuccess');
    const bookingDismissBtn = document.getElementById('bookingDismissBtn');

    // Inputs
    const clientName = document.getElementById('clientName');
    const clientEmail = document.getElementById('clientEmail');
    const clientPhone = document.getElementById('clientPhone');
    const appointmentDate = document.getElementById('appointmentDate');
    const marketingConsent = document.getElementById('marketingConsent');
    const consentError = document.getElementById('consentError');

    // Default to tomorrow 11:00 AM (taking into account the local time zone)
    const defaultDate = new Date();
    defaultDate.setDate(defaultDate.getDate() + 1);
    defaultDate.setHours(11, 0, 0, 0);

    const localDefaultDate = new Date(defaultDate.getTime() - defaultDate.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
    const localMinDate = new Date(new Date().getTime() - new Date().getTimezoneOffset() * 60000).toISOString().slice(0, 16);

    if (appointmentDate) {
      appointmentDate.value = localDefaultDate;
      appointmentDate.min = localMinDate;
    }

    function validateEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validateField(inputElement, isValid) {
      const parent = inputElement.closest('.form-group');
      const errorMsg = parent ? parent.querySelector('.error-msg') : null;

      if (!isValid) {
        if (parent) parent.classList.add('has-error');
        if (errorMsg) errorMsg.classList.remove('hidden');
        return false;
      } else {
        if (parent) parent.classList.remove('has-error');
        if (errorMsg) errorMsg.classList.add('hidden');
        return true;
      }
    }

    appointmentForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const isNameValid = validateField(clientName, clientName.value.trim().length >= 2);
      const isEmailValid = validateField(clientEmail, validateEmail(clientEmail.value.trim()));
      const isPhoneValid = validateField(clientPhone, clientPhone.value.trim().length >= 7);
      const isDateValid = validateField(appointmentDate, Boolean(appointmentDate.value));

      const isConsentGiven = marketingConsent ? marketingConsent.checked : true;
      if (!isConsentGiven && consentError) {
        consentError.style.display = 'block';
      } else if (consentError) {
        consentError.style.display = 'none';
      }

      if (isNameValid && isEmailValid && isPhoneValid && isDateValid && isConsentGiven) {
        // Populate modal data
        const confName = document.getElementById('confirmedClientName');
        const confService = document.getElementById('confirmedService');
        const confMaster = document.getElementById('confirmedMaster');
        const confDate = document.getElementById('confirmedDate');
        const confEmail = document.getElementById('confirmedEmail');

        if (confName) confName.textContent = clientName.value.trim();
        if (confService) confService.textContent = document.getElementById('serviceSelection').value;
        if (confMaster) confMaster.textContent = document.getElementById('masterSelection').value;

        if (confDate) {
          const parsedDate = new Date(appointmentDate.value);
          confDate.textContent = parsedDate.toLocaleString('en-US', {
            dateStyle: 'medium',
            timeStyle: 'short'
          });
        }
        if (confEmail) confEmail.textContent = clientEmail.value.trim();

        if (bookingSuccessModal) bookingSuccessModal.classList.add('open');

        // Reset
        appointmentForm.reset();
        appointmentDate.value = localDefaultDate;
      }
    });

    function closeBookingModal() {
      if (bookingSuccessModal) bookingSuccessModal.classList.remove('open');
    }

    if (closeBookingSuccess) closeBookingSuccess.addEventListener('click', closeBookingModal);
    if (bookingDismissBtn) bookingDismissBtn.addEventListener('click', closeBookingModal);
  }

  /* -------------------------------------------------------------------------
     2. LIGHTBOX MEDIA VIEWER
     ------------------------------------------------------------------------- */
  const galleryContainer = document.getElementById('galleryContainer');
  const lightbox = document.getElementById('lightbox');
  const lightboxImg = document.getElementById('lightboxImg');
  const lightboxCaption = document.getElementById('lightboxCaption');
  const closeLightbox = document.getElementById('closeLightbox');

  if (lightbox && galleryContainer) {
    galleryContainer.addEventListener('click', (e) => {
      const card = e.target.closest('.gallery-card');
      if (!card) return;

      const fullSrc = card.getAttribute('data-full');
      const title = card.querySelector('.card-style-title')?.textContent.trim() || 'Transformation';
      const tag = card.querySelector('.card-barber-tag')?.textContent.trim() || '';

      if (fullSrc && lightboxImg) {
        lightboxImg.src = fullSrc;
        if (lightboxCaption) {
          lightboxCaption.textContent = tag ? `${title} — ${tag}` : title;
        }
        lightbox.classList.add('open');
      }
    });

    if (closeLightbox) {
      closeLightbox.addEventListener('click', () => {
        lightbox.classList.remove('open');
      });
    }

    lightbox.addEventListener('click', (e) => {
      if (e.target === lightbox) {
        lightbox.classList.remove('open');
      }
    });
  }

  /* -------------------------------------------------------------------------
     3. ESCAPE KEY TO CLOSE ANY ACTIVE MODAL
     ------------------------------------------------------------------------- */
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const openModals = document.querySelectorAll('#bookingSuccessModal.open, #lightbox.open');
      openModals.forEach(modal => modal.classList.remove('open'));
    }
  });

});