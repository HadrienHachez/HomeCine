import {Movie} from "./movie";

export class Note {
    id: number;
    title: string = '';
    content: string = '';
    createdAt: Date;
    movie: any;

    constructor(values: Object = {}) {
        Object.assign(this, values);
    }
}