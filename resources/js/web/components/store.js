import { query, queryAll } from "../query";
import { common } from "../common";
import { SUCCESS_CODE } from "../constants";

export const store = {
  initModalStore: () => {
    common.initModal("store-modal");
  },

  listenShowStore: () => {
    if (storeId === "") {
      common.getModal("store-modal").show();
    }
    queryAll(".show-store").forEach((e) => {
      e.addEventListener("click", () => {
        common.getModal("store-modal").show();
      });
    });
  },

  listenChoiceStore: () => {
    query("#store-accept").addEventListener("click", (e) => {
      const storeId = query(".store-id:checked").value;
      common.getModal("store-modal").hide();
      axios
        .post(`${BASE_URL}/store/choice-store`, {
          store_id: storeId,
        })
        .then((response) => {
          if (response.data.code === SUCCESS_CODE) {
            window.location.reload();
          }
        });
    });
  },
};
