import { useState } from "react";


const baseUrl = process.env.REACT_APP_BASEURL

export const useDelete = () => {
  const [error, setError] = useState<boolean>(false);

  const deleteProducts = async (skus: string[]) => {
    const response = await fetch(baseUrl + '/delete', {
      method: 'POST',
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