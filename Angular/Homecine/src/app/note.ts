import { Movie } from './movie';

export class Note {
  id: number;
  user: string;
  score: number;
  createdAt: Date;
  Movie: Movie;
  commentary: string;
  MovieID?: number;
}
