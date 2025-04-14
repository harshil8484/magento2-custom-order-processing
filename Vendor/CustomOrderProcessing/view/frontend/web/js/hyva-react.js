document.addEventListener("alpine:init", () => {
  Alpine.data("orderStatus", () => ({
    async updateStatus(orderId, newStatus) {
      const response = await fetch(
        `${window.BASE_URL}rest/V1/custom-order/status-update`,
        {
          method: "POST",
          headers: {
            Authorization: `Bearer ${window.API_TOKEN}`,
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            orderIncrementId: orderId,
            newStatus: newStatus,
          }),
        }
      );
      return await response.json();
    },
  }));
});
