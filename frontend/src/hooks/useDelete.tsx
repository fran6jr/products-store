import { useState } from "react";
import { baseUrl } from "./baseUrl";

export const useDelete = () => {
  const [error, setError] = useState<boolean>(false);

  const deleteProducts = async (skus: string[]) => {
    const response = await fetch(baseUrl + '/delete', {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(skus)
    });
    if (!response.ok) {
      setError(true);
    }

    return error;

  }

  return deleteProducts;

  }