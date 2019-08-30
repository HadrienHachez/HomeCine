import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import ky from 'ky';

@Component({
  selector: 'app-search',
  templateUrl: './search.component.html',
  styleUrls: ['./search.component.css']
})
export class SearchComponent implements OnInit {
  movies: any;
  private q: string;

  constructor(private route: ActivatedRoute) {}

  ngOnInit() {
    this.route.queryParamMap.subscribe(params => {
      const queryParam = { ...params['params'] };
      this.q = queryParam.q;
    });
    //this.getMoviesFromAllocine();
  }
  /*
  async getMoviesFromAllocine() {
    const parsed = await ky
      .get('http://api.allocine.fr/rest/v3/search', {
        searchParams: { partner: '100043982026', q: this.q, format: 'json', filter: 'movie' }
      });
    this.movies = parsed;
  }*/
}
