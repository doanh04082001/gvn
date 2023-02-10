const toastrOptions = {
  closeButton: true,
  timeOut: 3000,
};

export const showSuccess = (message = "message", options = null) => {
  toastr.options = { ...toastr.options, ...(options ?? toastrOptions) };
  toastr.success(message);
};

export const showError = (message = "message", options = null) => {
  toastr.options = { ...toastr.options, ...(options ?? toastrOptions) };
  toastr.error(message);
};

const confirmConfig = {
  title: CONFIRM_TITLE_TEXT,
  text: CONFIRM_CONTENT_TEXT,
  type: "warning",
  showCancelButton: true,
  customClass: {
    confirmButton: "btn btn-warning",
    cancelButton: "ml-2 btn btn-default",
  },
  buttonsStyling: false,
  confirmButtonText: OK_TEXT,
  cancelButtonText: CANCEL_TEXT,
};

export const delConfirmConfig = {
  ...confirmConfig,
  ...{
    title: CONFIRM_DELETE_TEXT,
    text: CONFIRM_DELETE_HINT_TEXT,
    type: "warning",
    customClass: {
      confirmButton: "btn btn-danger",
      cancelButton: "ml-2 btn btn-default",
    },
  },
};

export const showConfirmConfig = {
  ...confirmConfig,
  ...{
    showDenyButton: true,
    denyButtonText: `Từ chối`,
    customClass: {
      confirmButton: "btn btn-success",
      denyButton: "btn btn-danger",
      cancelButton: "ml-2 btn btn-default",
    },
  },
};

export const showDeleteConfirm = (
  handleClickOkBtn,
  handleClickCancelBtn = null,
  config = null
) =>
  showConfirm(
    handleClickOkBtn,
    handleClickCancelBtn,
    config ?? delConfirmConfig
  );

export const showModalConfirm = (
  handleClickOkBtn,
  handleClickNoBtn,
  handleClickCancelBtn = null,
  config = null
) =>
  showConfirm(
    handleClickOkBtn,
    handleClickNoBtn,
    handleClickCancelBtn,
    config ?? showConfirmConfig
  );

export const showConfirm = (
  handleClickOkBtn,
  handleClickNoBtn,
  handleClickCancelBtn = null,
  config = null
) => {
  Swal.fire(config ? { ...confirmConfig, ...config } : confirmConfig).then(
    (result) => {
      if (typeof handleClickOkBtn === "function" && result.value) {
        // console.log(result.value);
        return handleClickOkBtn(result.value);
      }
      if (typeof handleClickNoBtn === "function" && result.isDenied) {
        // console.log(result.value);
        return handleClickNoBtn(result.isDenied);
      }
      if (
        typeof handleClickCancelBtn === "function" &&
        ["backdrop", "cancel"].includes(result.dismiss)
      ) {
        // console.log(result);
        handleClickCancelBtn(result.dismiss);
      }
    }
  );
};

export const showResponseErrorMessage = (error) => {
  console.error(error);

  const response = error?.response ?? {};
  let message = UNKNOWN_ERROR_MESSAGE;

  switch (response?.status ?? 0) {
    case 401:
      message = UNAUTHENTICATED_ERROR_MESSAGE;
      break;
    case 403:
      message = UNAUTHORIZED_ERROR_MESSAGE;
      break;
    case 404:
      message = NOTFOUND_ERROR_MESSAGE;
      break;
    case 422:
      message = DATA_WAS_INVALID_ERROR_MESSAGE;
      break;
    case 500:
      message = INTERNAL_SERVER_ERROR_MESSAGE;
      break;
    default:
      break;
  }

  showError(message);
};
