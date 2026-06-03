import { reactive } from "vue";

const toast = reactive({ message: "", type: "success", visible: false });

let timer = null;

export function showToast(message, type = "success") {
  toast.message = message;
  toast.type = type;
  toast.visible = true;
  clearTimeout(timer);
  timer = setTimeout(() => {
    toast.visible = false;
  }, 3000);
}

export function useToast() {
  return { toast, showToast };
}
