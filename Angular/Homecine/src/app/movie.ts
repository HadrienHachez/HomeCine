import { Note } from './note';

export class Movie {
  id: number;
  title: string;
  originalTitle: string;
  productionYear: number;
  directors: string;
  actors: string;
  note: Note[];
  synopsis: string;
}
